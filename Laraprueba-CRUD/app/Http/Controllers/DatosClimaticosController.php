<?php

namespace App\Http\Controllers;

use App\Services\OpenMeteoService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DatosClimaticosController extends Controller
{
    /**
     * Mostrar página de datos climáticos históricos (última semana)
     */
    public function index(OpenMeteoService $weather)
    {
        // Coordenadas de San José de Chiquitos, Bolivia
        $latitude = -17.8857;
        $longitude = -60.7556;
        
        // Obtener datos de los últimos 7 días
        $fechaFin = Carbon::now();
        $fechaInicio = Carbon::now()->subDays(7);
        
        // Obtener datos históricos
        $weatherData = $weather->getHistoricalWeather(
            $latitude, 
            $longitude, 
            $fechaInicio->format('Y-m-d'),
            $fechaFin->format('Y-m-d')
        );
        
        // Procesar datos para las gráficas
        $datosGraficas = $this->procesarDatosParaGraficas($weatherData);
        
        return view('datos-climaticos.index', [
            'datosGraficas' => $datosGraficas,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'ubicacion' => 'San José de Chiquitos, Bolivia'
        ]);
    }
    
    /**
     * Procesar datos para las gráficas
     */
    private function procesarDatosParaGraficas($weatherData)
    {
        if (!isset($weatherData['data']['hourly'])) {
            return [
                'labels' => [],
                'temperatura' => [],
                'humedad' => [],
                'precipitacion' => [],
                'viento' => [],
            ];
        }
        
        $hourly = $weatherData['data']['hourly'];
        
        return [
            'labels' => $hourly['time'] ?? [],
            'temperatura' => $hourly['temperature_2m'] ?? [],
            'humedad' => $hourly['relative_humidity_2m'] ?? [],
            'precipitacion' => $hourly['precipitation'] ?? [],
            'viento' => $hourly['wind_speed_10m'] ?? [],
        ];
    }
}
