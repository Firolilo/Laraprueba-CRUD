<?php

use Illuminate\Support\Facades\Route;

// Authentication routes
Auth::routes();

// Public/Guest routes
Route::middleware('guest')->group(function () {
    // Redirect root to login if not authenticated
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    
    // Dashboard - accessible to all authenticated users
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Datos Climáticos - históricos de la última semana
    Route::get('/datos-climaticos', [\App\Http\Controllers\DatosClimaticosController::class, 'index'])
        ->name('datos-climaticos.index');
    
    // Biomasas GeoJSON endpoint for map
    Route::get('/dashboard/biomasas', [\App\Http\Controllers\DashboardController::class, 'getBiomasas'])
        ->name('dashboard.biomasas');

    // Test endpoint to preview OpenWeather and FIRMS data
    Route::get('/test', [\App\Http\Controllers\TestController::class, 'index'])
        ->name('test.index');
    
    // Debug endpoint para ver biomasas
    Route::get('/debug/biomasas', function() {
        $biomasas = \App\Models\Biomasa::with('tipoBiomasa')->get();
        return response()->json([
            'total' => $biomasas->count(),
            'aprobadas' => $biomasas->where('estado', 'aprobada')->count(),
            'biomasas' => $biomasas->map(function($b) {
                return [
                    'id' => $b->id,
                    'tipo' => $b->tipoBiomasa->tipo_biomasa ?? 'N/A',
                    'estado' => $b->estado,
                    'coordenadas' => $b->coordenadas,
                    'coordenadas_type' => gettype($b->coordenadas),
                    'area_m2' => $b->area_m2,
                ];
            })
        ]);
    });
    
    Route::get('/home', function () {
        return redirect('/');
    });

    // ============================================
    // BIOMASAS - Accesible para Voluntarios y Administradores
    // ============================================
    Route::middleware('role:voluntario')->group(function () {
        // RUTA DE TEST
        Route::get('biomasas/test-create', function() {
            $tipoBiomasas = \App\Models\TipoBiomasa::all();
            return view('biomasa.test-create', compact('tipoBiomasas'));
        })->name('biomasas.test-create');
        
        // CRUD de biomasas (voluntarios y administradores)
        Route::resource('biomasas', App\Http\Controllers\BiomasaController::class);
    });

    // ============================================
    // VOLUNTARIO ROUTES (Voluntarios y Administradores)
    // ============================================
    Route::middleware('role:voluntario')->group(function () {
        // Simulador avanzado - Voluntarios pueden usar pero NO guardar
        Route::get('simulaciones/simulator', [App\Http\Controllers\SimulacioneController::class, 'simulator'])
            ->name('simulaciones.simulator');
        
        // Predictions - Voluntarios pueden ver
        Route::get('predictions', [App\Http\Controllers\PredictionController::class, 'index'])
            ->name('predictions.index');
        // IMPORTANTE: create debe ir ANTES que {prediction} para evitar conflictos
        Route::get('predictions/create', [App\Http\Controllers\PredictionController::class, 'create'])
            ->name('predictions.create');
        Route::get('predictions/{prediction}', [App\Http\Controllers\PredictionController::class, 'show'])
            ->name('predictions.show');
    });

    // ============================================
    // ADMINISTRADOR ROUTES (Solo Administradores)
    // ============================================
    Route::middleware('role:administrador')->group(function () {
        
        // Biomasas - Moderación (aprobar/rechazar)
        Route::post('biomasas/{id}/aprobar', [App\Http\Controllers\BiomasaController::class, 'aprobar'])
            ->name('biomasas.aprobar');
        Route::post('biomasas/{id}/rechazar', [App\Http\Controllers\BiomasaController::class, 'rechazar'])
            ->name('biomasas.rechazar');
        
        // Users management
        Route::resource('users', App\Http\Controllers\UserController::class);
        
        // Tipo Biomasas catalog
        Route::resource('tipo-biomasas', App\Http\Controllers\TipoBiomasaController::class);
        
        // Administradores management
        Route::resource('administradores', App\Http\Controllers\AdministradorController::class);
        
        // Voluntarios management
        Route::resource('voluntarios', App\Http\Controllers\VoluntarioController::class);
        
        // Simulaciones - Full CRUD (save, edit, delete)
        Route::post('simulaciones/save-simulation', [App\Http\Controllers\SimulacioneController::class, 'saveSimulation'])
            ->name('simulaciones.save');
        Route::get('simulaciones/history', [App\Http\Controllers\SimulacioneController::class, 'getHistory'])
            ->name('simulaciones.history');
        Route::delete('simulaciones/delete/{id}', [App\Http\Controllers\SimulacioneController::class, 'deleteSimulation'])
            ->name('simulaciones.delete');
        Route::resource('simulaciones', App\Http\Controllers\SimulacioneController::class);
        
        // Focos de incendio - Full CRUD
        Route::resource('focos-incendios', App\Http\Controllers\FocosIncendioController::class);
        
        // Importar focos desde FIRMS (ruta web para evitar problemas de autenticación)
        Route::post('focos-incendios/import/firms', [App\Http\Controllers\FocosIncendioController::class, 'importFromFirms'])
            ->name('focos-incendios.import-firms');
        
        // Predictions - Full CRUD (solo edit, update, delete ya que create está arriba para todos)
        Route::post('predictions', [App\Http\Controllers\PredictionController::class, 'store'])
            ->name('predictions.store');
        Route::get('predictions/{prediction}/edit', [App\Http\Controllers\PredictionController::class, 'edit'])
            ->name('predictions.edit');
        Route::patch('predictions/{prediction}', [App\Http\Controllers\PredictionController::class, 'update'])
            ->name('predictions.update');
        Route::delete('predictions/{prediction}', [App\Http\Controllers\PredictionController::class, 'destroy'])
            ->name('predictions.destroy');
    });
});
