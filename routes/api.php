<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Api\BiomasaController;
use App\Http\Controllers\Api\FocosIncendioController;
use App\Http\Controllers\Api\TipoBiomasaController;
use App\Http\Controllers\Api\SimulacionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas públicas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Predicciones
    Route::apiResource('predictions', PredictionController::class);
    
    // Biomasas
    Route::apiResource('biomasas', BiomasaController::class);
    
    // Focos de Incendio
    Route::apiResource('focos-incendios', FocosIncendioController::class);
    
    // Tipos de Biomasa
    Route::apiResource('tipos-biomasa', TipoBiomasaController::class);
    
    // Simulaciones
    Route::apiResource('simulaciones', SimulacionController::class);
});

// Rutas públicas de solo lectura (sin autenticación)
Route::get('/public/focos-incendios', [FocosIncendioController::class, 'index']);
Route::get('/public/tipos-biomasa', [TipoBiomasaController::class, 'index']);
