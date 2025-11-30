<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BiomasaController;
use App\Http\Controllers\Api\FocosIncendioController;
use App\Http\Controllers\Api\TipoBiomasaController;
use App\Http\Controllers\Api\SimulacionController;
use App\Http\Controllers\Api\PredictionController;

// API abierta sin autenticación
Route::apiResource('focos-incendios', FocosIncendioController::class);
Route::apiResource('biomasas', BiomasaController::class);
Route::apiResource('tipos-biomasa', TipoBiomasaController::class);
Route::apiResource('simulaciones', SimulacionController::class);
Route::apiResource('predictions', PredictionController::class);

// Rutas adicionales de compatibilidad
Route::get('/public/focos-incendios', [FocosIncendioController::class, 'index']);
Route::get('/public/biomasas', [BiomasaController::class, 'index']);
Route::get('/public/tipos-biomasa', [TipoBiomasaController::class, 'index']);
