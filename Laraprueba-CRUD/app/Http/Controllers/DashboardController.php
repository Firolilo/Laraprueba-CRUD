<?php

namespace App\Http\Controllers;

use App\Models\Biomasa;
use App\Services\OpenMeteoService;
use App\Services\FirmsDataService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with map, weather, and statistics.
     */
    public function index(OpenMeteoService $weather, FirmsDataService $firms)
    {
        // Coordinates: San José de Chiquitos, Bolivia
        $latitude = -17.8857;
        $longitude = -60.7556;

        // Get current weather
        $weatherData = $weather->getCurrentWeather($latitude, $longitude);
        
        // Get fire hotspots from Chiquitanía area (last 2 days for demo, clustered)
        // Area: west,south,east,north = -62.5,-18.5,-57.5,-14.5
        // Clustering radius: 20km (fires within 20km are grouped as one hotspot)
        $firesData = $firms->getFireData('VIIRS_NOAA20_NRT', '-62.5,-18.5,-57.5,-14.5', 2, true, 20.0);

        // Count biomasas APROBADAS
        $biomasasCount = Biomasa::aprobadas()->count();
        
        // Count active fires
        $firesCount = isset($firesData['data']) ? count($firesData['data']) : 0;

        return view('dashboard', [
            'weather' => $weatherData,
            'fires' => $firesData,
            'biomasasCount' => $biomasasCount,
            'firesCount' => $firesCount,
        ]);
    }

    /**
     * API endpoint to get biomasas as GeoJSON for map rendering.
     * Solo retorna biomasas APROBADAS para el mapa público.
     */
    public function getBiomasas()
    {
        // Solo mostrar biomasas aprobadas en el mapa del dashboard
        $biomasas = Biomasa::aprobadas()->with('tipoBiomasa')->get();

        $features = $biomasas->map(function ($biomasa) {
            // Parse coordenadas if it's a string
            $coords = is_string($biomasa->coordenadas) 
                ? json_decode($biomasa->coordenadas, true) 
                : $biomasa->coordenadas;

            // Invertir coordenadas de [lat,lng] a [lng,lat] para GeoJSON
            $coordsGeoJSON = [];
            if (is_array($coords)) {
                foreach ($coords as $point) {
                    if (is_array($point) && count($point) >= 2) {
                        // Invertir: de [lat, lng] a [lng, lat]
                        $coordsGeoJSON[] = [$point[1], $point[0]];
                    }
                }
            }

            return [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => [$coordsGeoJSON],
                ],
                'properties' => [
                    'id' => $biomasa->id,
                    'ubicacion' => $biomasa->ubicacion ?? 'Sin ubicación',
                    'area' => number_format($biomasa->area_m2 ?? 0, 2) . ' km²',
                    'densidad' => $biomasa->densidad ?? 'N/A',
                    'tipo' => $biomasa->tipoBiomasa->tipo_biomasa ?? 'N/A',
                    'color' => $biomasa->tipoBiomasa->color ?? '#28a745',
                    'fecha' => $biomasa->fecha_reporte 
                        ? $biomasa->fecha_reporte->format('d/m/Y') 
                        : ($biomasa->created_at ? $biomasa->created_at->format('d/m/Y') : 'N/A'),
                    'descripcion' => $biomasa->descripcion ?? '',
                ],
            ];
        });

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features,
        ]);
    }
}
