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
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Test endpoint to preview OpenWeather and FIRMS data
    Route::get('/test', [\App\Http\Controllers\TestController::class, 'index'])
        ->name('test.index');
    
    Route::get('/home', function () {
        return redirect('/');
    });

    // ============================================
    // VOLUNTARIO ROUTES (Voluntarios y Administradores)
    // ============================================
    Route::middleware('role:voluntario')->group(function () {
        // Biomasas - Voluntarios pueden crear/ver
        Route::resource('biomasas', App\Http\Controllers\BiomasaController::class);
        
        // Simulador avanzado - Voluntarios pueden usar pero NO guardar
        Route::get('simulaciones/simulator', [App\Http\Controllers\SimulacioneController::class, 'simulator'])
            ->name('simulaciones.simulator');
        
        // Predictions - Voluntarios pueden ver
        Route::get('predictions', [App\Http\Controllers\PredictionController::class, 'index'])
            ->name('predictions.index');
        Route::get('predictions/{prediction}', [App\Http\Controllers\PredictionController::class, 'show'])
            ->name('predictions.show');
    });

    // ============================================
    // ADMINISTRADOR ROUTES (Solo Administradores)
    // ============================================
    Route::middleware('role:administrador')->group(function () {
        
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
        
        // Predictions - Full CRUD (create, edit, delete)
        Route::post('predictions', [App\Http\Controllers\PredictionController::class, 'store'])
            ->name('predictions.store');
        Route::get('predictions/create', [App\Http\Controllers\PredictionController::class, 'create'])
            ->name('predictions.create');
        Route::get('predictions/{prediction}/edit', [App\Http\Controllers\PredictionController::class, 'edit'])
            ->name('predictions.edit');
        Route::patch('predictions/{prediction}', [App\Http\Controllers\PredictionController::class, 'update'])
            ->name('predictions.update');
        Route::delete('predictions/{prediction}', [App\Http\Controllers\PredictionController::class, 'destroy'])
            ->name('predictions.destroy');
    });
});
