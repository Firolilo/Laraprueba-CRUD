<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'SIPII API - Sistema de Información de Prevención de Incendios',
        'version' => '1.0.0',
        'endpoints' => [
            'focos-incendios' => '/api/focos-incendios',
            'biomasas' => '/api/biomasas',
            'tipos-biomasa' => '/api/tipos-biomasa',
            'simulaciones' => '/api/simulaciones',
            'predictions' => '/api/predictions',
        ],
        'docs' => 'Ver README.md para documentación completa'
    ]);
});
