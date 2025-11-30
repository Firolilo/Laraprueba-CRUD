<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Internal API endpoints for weather and fire data.
| These mirror the JS services from SIPII_WEB_V2.
|
*/

// Weather API - Open-Meteo (current & historical)
Route::get('/weather', [App\Http\Controllers\Api\WeatherController::class, 'index'])
    ->name('api.weather');

// Fire data API - Parse CSV from internal FIRMS endpoint
Route::get('/fires', [App\Http\Controllers\Api\FiresController::class, 'index'])
    ->name('api.fires');
