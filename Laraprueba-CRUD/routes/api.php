<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BiomasaController;
use App\Http\Controllers\Api\FocosIncendioController;
use App\Http\Controllers\Api\TipoBiomasaController;
use App\Http\Controllers\Api\SimulacionController;
use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\Api\FiresController;

/*
|--------------------------------------------------------------------------
| API Routes - SIPII Consolidated
|--------------------------------------------------------------------------
|
| Unified REST API for both web panel and Flutter mobile app.
| Includes authentication (Sanctum), CRUD operations, and external data.
|
*/

// ============================================================================
// AUTHENTICATION ENDPOINTS (Sanctum)
// ============================================================================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected endpoints - require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// ============================================================================
// EXTERNAL DATA ENDPOINTS (Weather & Fire Data)
// ============================================================================
// Weather API - Open-Meteo (current & historical)
Route::get('/weather', [WeatherController::class, 'index'])->name('api.weather');

// Fire data API - NASA FIRMS
Route::get('/fires', [FiresController::class, 'index'])->name('api.fires');

// ============================================================================
// PUBLIC ENDPOINTS (no authentication required)
// ============================================================================
Route::prefix('public')->group(function () {
    Route::get('/focos-incendios', [FocosIncendioController::class, 'index']);
    Route::get('/biomasas', [BiomasaController::class, 'index']);
    Route::get('/tipos-biomasa', [TipoBiomasaController::class, 'index']);
});

// ============================================================================
// PROTECTED API RESOURCES (require authentication)
// ============================================================================
Route::middleware('auth:sanctum')->group(function () {
    // Biomasas - Full CRUD
    Route::apiResource('biomasas', BiomasaController::class)->names([
        'index' => 'api.biomasas.index',
        'store' => 'api.biomasas.store',
        'show' => 'api.biomasas.show',
        'update' => 'api.biomasas.update',
        'destroy' => 'api.biomasas.destroy',
    ]);
    
    // Focos de Incendio - Full CRUD
    Route::apiResource('focos-incendios', FocosIncendioController::class)->names([
        'index' => 'api.focos-incendios.index',
        'store' => 'api.focos-incendios.store',
        'show' => 'api.focos-incendios.show',
        'update' => 'api.focos-incendios.update',
        'destroy' => 'api.focos-incendios.destroy',
    ]);
    
    // Predictions - Full CRUD
    Route::apiResource('predictions', PredictionController::class)->names([
        'index' => 'api.predictions.index',
        'store' => 'api.predictions.store',
        'show' => 'api.predictions.show',
        'update' => 'api.predictions.update',
        'destroy' => 'api.predictions.destroy',
    ]);
    
    // ========================================================================
    // ADMIN-ONLY ENDPOINTS (role:administrador)
    // ========================================================================
    Route::middleware('role:administrador')->group(function () {
        // Tipos de Biomasa - Full CRUD (admin only)
        Route::apiResource('tipos-biomasa', TipoBiomasaController::class)->names([
            'index' => 'api.tipos-biomasa.index',
            'store' => 'api.tipos-biomasa.store',
            'show' => 'api.tipos-biomasa.show',
            'update' => 'api.tipos-biomasa.update',
            'destroy' => 'api.tipos-biomasa.destroy',
        ]);
        
        // Simulaciones - Partial CRUD (admin only)
        Route::get('/simulaciones', [SimulacionController::class, 'index']);
        Route::post('/simulaciones', [SimulacionController::class, 'store']);
        Route::get('/simulaciones/{simulacione}', [SimulacionController::class, 'show']);
        Route::delete('/simulaciones/{simulacione}', [SimulacionController::class, 'destroy']);
    });
});
