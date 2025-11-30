<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BiomasaController;
use App\Http\Controllers\Api\FocosIncendioController;
use App\Http\Controllers\Api\TipoBiomasaController;
use App\Http\Controllers\Api\SimulacionController;
use App\Http\Controllers\Api\PredictionController;

// ============================================
// 🔐 AUTENTICACIÓN (sin auth)
// ============================================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ============================================
// 📖 RUTAS PÚBLICAS (sin autenticación)
// ============================================
Route::get('/public/focos-incendios', [FocosIncendioController::class, 'index']);
Route::get('/public/biomasas', [BiomasaController::class, 'index']);
Route::get('/public/tipos-biomasa', [TipoBiomasaController::class, 'index']);

// ============================================
// 🔒 RUTAS PROTEGIDAS (requieren autenticación)
// ============================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Usuario autenticado
    Route::get('/user', function (Request $request) {
        $user = $request->user()->load(['administrador', 'voluntario']);
        return response()->json([
            'user' => $user,
            'role' => $user->getRoleType(),
            'is_admin' => $user->isAdministrador(),
            'is_volunteer' => $user->isVoluntario(),
        ]);
    });

    // ============================================
    // 🔥 FOCOS DE INCENDIO (Todos autenticados)
    // ============================================
    Route::apiResource('focos-incendios', FocosIncendioController::class);

    // ============================================
    // 🌿 BIOMASAS
    // Voluntarios: solo index, show, store
    // Administradores: CRUD completo
    // ============================================
    Route::get('biomasas', [BiomasaController::class, 'index']);
    Route::get('biomasas/{biomasa}', [BiomasaController::class, 'show']);
    Route::post('biomasas', [BiomasaController::class, 'store']); // Voluntarios pueden crear
    Route::put('biomasas/{biomasa}', [BiomasaController::class, 'update'])->middleware('role:administrador');
    Route::delete('biomasas/{biomasa}', [BiomasaController::class, 'destroy'])->middleware('role:administrador');

    // ============================================
    // 🎨 TIPOS DE BIOMASA (Solo Administradores)
    // ============================================
    Route::get('tipos-biomasa', [TipoBiomasaController::class, 'index']); // Todos pueden ver
    Route::get('tipos-biomasa/{tipoBiomasa}', [TipoBiomasaController::class, 'show']);
    Route::post('tipos-biomasa', [TipoBiomasaController::class, 'store'])->middleware('role:administrador');
    Route::put('tipos-biomasa/{tipoBiomasa}', [TipoBiomasaController::class, 'update'])->middleware('role:administrador');
    Route::delete('tipos-biomasa/{tipoBiomasa}', [TipoBiomasaController::class, 'destroy'])->middleware('role:administrador');

    // ============================================
    // 🎮 SIMULACIONES
    // Voluntarios: pueden usar simulador (no guardar)
    // Administradores: CRUD completo
    // ============================================
    Route::get('simulaciones', [SimulacionController::class, 'index'])->middleware('role:administrador');
    Route::get('simulaciones/{simulacione}', [SimulacionController::class, 'show'])->middleware('role:administrador');
    Route::post('simulaciones', [SimulacionController::class, 'store'])->middleware('role:administrador');
    Route::put('simulaciones/{simulacione}', [SimulacionController::class, 'update'])->middleware('role:administrador');
    Route::delete('simulaciones/{simulacione}', [SimulacionController::class, 'destroy'])->middleware('role:administrador');

    // ============================================
    // 📊 PREDICCIONES (Todos pueden crear y ver)
    // ============================================
    Route::apiResource('predictions', PredictionController::class);
});
