<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\FocosIncendio;
use App\Http\Requests\PredictionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class PredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $predictions = Prediction::with('focoIncendio')->latest()->paginate(10);

        return view('prediction.index', compact('predictions'))
            ->with('i', ($request->input('page', 1) - 1) * $predictions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $prediction = new Prediction();
        $focosIncendios = FocosIncendio::whereNotNull('coordenadas')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('prediction.create', compact('prediction', 'focosIncendios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'foco_incendio_id' => 'required|exists:focos_incendios,id',
            'temperature' => 'required|numeric|min:0|max:60',
            'humidity' => 'required|numeric|min:0|max:100',
            'wind_speed' => 'required|numeric|min:0|max:200',
            'wind_direction' => 'required|integer|min:0|max:360',
            'prediction_hours' => 'required|integer|min:1|max:72',
            'terrain_type' => 'required|string',
        ]);

        $foco = FocosIncendio::findOrFail($request->foco_incendio_id);

        // Generar predicción usando algoritmo
        $predictionData = $this->generatePrediction(
            $foco,
            $request->temperature,
            $request->humidity,
            $request->wind_speed,
            $request->wind_direction,
            $request->prediction_hours,
            $request->terrain_type
        );

        $prediction = Prediction::create([
            'foco_incendio_id' => $foco->id,
            'predicted_at' => now(),
            'path' => $predictionData['path'],
            'meta' => $predictionData['meta'],
        ]);

        return redirect()->route('predictions.show', $prediction->id)
            ->with('success', 'Predicción generada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $prediction = Prediction::with('focoIncendio')->findOrFail($id);

        return view('prediction.show', compact('prediction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $prediction = Prediction::findOrFail($id);
        $focosIncendios = FocosIncendio::whereNotNull('coordenadas')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('prediction.edit', compact('prediction', 'focosIncendios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PredictionRequest $request, Prediction $prediction): RedirectResponse
    {
        $prediction->update($request->validated());

        return redirect()->route('predictions.index')
            ->with('success', 'Predicción actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        Prediction::findOrFail($id)->delete();

        return redirect()->route('predictions.index')
            ->with('success', 'Predicción eliminada exitosamente');
    }

    /**
     * Generar predicción usando algoritmo de propagación de incendios
     */
    private function generatePrediction(
        FocosIncendio $foco,
        float $temperature,
        float $humidity,
        float $windSpeed,
        int $windDirection,
        int $hours,
        string $terrainType
    ): array {
        $startLat = $foco->coordenadas[0];
        $startLng = $foco->coordenadas[1];
        $intensity = $foco->intensidad ?? 5;

        // Factores de propagación según tipo de terreno
        $terrainFactors = [
            'bosque_denso' => 1.5,
            'bosque_normal' => 1.2,
            'pastizal' => 1.0,
            'matorral' => 0.8,
            'rocoso' => 0.3,
        ];

        $terrainFactor = $terrainFactors[$terrainType] ?? 1.0;

        // Calcular velocidad de propagación (km/h)
        $baseSpeed = 0.5; // velocidad base
        $tempFactor = ($temperature / 30) * 0.5; // mayor temperatura = más rápido
        $humFactor = (1 - ($humidity / 100)) * 0.3; // menor humedad = más rápido
        $windFactor = ($windSpeed / 20) * 0.7; // más viento = más rápido
        
        $spreadSpeed = $baseSpeed + $tempFactor + $humFactor + $windFactor;
        $spreadSpeed *= $terrainFactor;

        // Calcular índice de peligro
        $fireRisk = $this->calculateFireRisk($temperature, $humidity, $windSpeed);

        // Generar trayectoria hora por hora
        $path = [];
        $currentLat = $startLat;
        $currentLng = $startLng;
        $currentIntensity = $intensity;

        // Convertir dirección del viento a radianes
        $windRad = deg2rad($windDirection);

        // Área afectada acumulada
        $totalArea = 0;
        $perimeterGrowth = [];

        for ($hour = 0; $hour <= $hours; $hour++) {
            // Calcular desplazamiento basado en viento y variación aleatoria
            $mainDirection = $windRad;
            $lateralSpread = 0.3; // propagación lateral
            
            // Distancia recorrida en esta hora (en grados)
            $distance = ($spreadSpeed / 111) * (1 + ($hour * 0.1)); // aumenta con el tiempo
            
            // Componente principal (dirección del viento)
            $latOffset = $distance * cos($mainDirection) * (0.8 + rand(0, 40) / 100);
            $lngOffset = $distance * sin($mainDirection) * (0.8 + rand(0, 40) / 100);
            
            // Añadir propagación lateral
            $lateralOffset = $distance * $lateralSpread * (rand(-50, 50) / 100);
            $latOffset += $lateralOffset * sin($mainDirection);
            $lngOffset += $lateralOffset * cos($mainDirection);

            $currentLat += $latOffset;
            $currentLng += $lngOffset;

            // Calcular intensidad decreciente con el tiempo
            $currentIntensity = max(1, $intensity * (1 - ($hour * 0.05)));

            // Calcular área afectada (círculo de radio creciente)
            $radius = $spreadSpeed * $hour; // km
            $area = pi() * pow($radius, 2); // km²
            $totalArea = $area;

            // Calcular perímetro
            $perimeter = 2 * pi() * $radius;
            $perimeterGrowth[] = round($perimeter, 2);

            $path[] = [
                'hour' => $hour,
                'lat' => round($currentLat, 6),
                'lng' => round($currentLng, 6),
                'intensity' => round($currentIntensity, 2),
                'spread_radius_km' => round($radius, 3),
                'affected_area_km2' => round($area, 3),
                'perimeter_km' => round($perimeter, 2),
            ];
        }

        // Punto final predicho
        $finalPoint = end($path);

        // Calcular distancia total recorrida
        $totalDistance = $this->calculateDistance(
            $startLat, $startLng,
            $finalPoint['lat'], $finalPoint['lng']
        );

        // Probabilidad de contención según factores
        $containmentProbability = $this->calculateContainmentProbability(
            $fireRisk, $terrainType, $hours, $windSpeed
        );

        // Recursos necesarios estimados
        $estimatedResources = $this->estimateResources($totalArea, $fireRisk, $terrainType);

        // Metadatos completos
        $meta = [
            // Parámetros de entrada
            'input_parameters' => [
                'temperature' => $temperature,
                'humidity' => $humidity,
                'wind_speed' => $windSpeed,
                'wind_direction' => $windDirection,
                'prediction_hours' => $hours,
                'terrain_type' => $terrainType,
                'initial_intensity' => $intensity,
            ],
            
            // Índices calculados
            'fire_risk_index' => $fireRisk,
            'spread_speed_kmh' => round($spreadSpeed, 2),
            'terrain_factor' => $terrainFactor,
            
            // Resultados finales
            'final_position' => [
                'lat' => $finalPoint['lat'],
                'lng' => $finalPoint['lng'],
                'intensity' => $finalPoint['intensity'],
            ],
            
            // Estadísticas
            'total_distance_km' => round($totalDistance, 2),
            'total_area_affected_km2' => round($totalArea, 2),
            'final_perimeter_km' => round($finalPoint['perimeter_km'], 2),
            'max_spread_radius_km' => round($finalPoint['spread_radius_km'], 2),
            
            // Probabilidades y evaluación
            'containment_probability' => round($containmentProbability * 100, 1),
            'danger_level' => $this->getDangerLevel($fireRisk),
            'propagation_rate' => $this->getPropagationRate($spreadSpeed),
            
            // Recursos estimados
            'estimated_resources' => $estimatedResources,
            
            // Recomendaciones
            'recommendations' => $this->generateRecommendations(
                $fireRisk, $terrainType, $windSpeed, $totalArea
            ),
            
            // Cronología de crecimiento
            'perimeter_growth_timeline' => $perimeterGrowth,
            
            // Metadatos del algoritmo
            'algorithm_version' => '1.0',
            'prediction_confidence' => $this->calculateConfidence($foco, $humidity, $windSpeed),
            'generated_at' => now()->toIso8601String(),
        ];

        return [
            'path' => $path,
            'meta' => $meta,
        ];
    }

    /**
     * Calcular índice de riesgo de incendio (0-100)
     */
    private function calculateFireRisk(float $temp, float $humidity, float $windSpeed): int
    {
        $tempFactor = min($temp / 40, 1) * 40;
        $humFactor = (1 - ($humidity / 100)) * 30;
        $windFactor = min($windSpeed / 30, 1) * 30;
        
        return min(round($tempFactor + $humFactor + $windFactor), 100);
    }

    /**
     * Calcular distancia entre dos puntos en km
     */
    private function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }

    /**
     * Calcular probabilidad de contención
     */
    private function calculateContainmentProbability(
        int $fireRisk,
        string $terrainType,
        int $hours,
        float $windSpeed
    ): float {
        $baseProbability = 0.7;
        
        // Reducir por riesgo
        $baseProbability -= ($fireRisk / 100) * 0.3;
        
        // Reducir por tiempo
        $baseProbability -= ($hours / 72) * 0.2;
        
        // Reducir por viento
        $baseProbability -= min($windSpeed / 50, 1) * 0.15;
        
        // Ajustar por terreno
        $terrainAdjustment = [
            'bosque_denso' => -0.2,
            'bosque_normal' => -0.1,
            'pastizal' => 0,
            'matorral' => 0.1,
            'rocoso' => 0.2,
        ];
        
        $baseProbability += $terrainAdjustment[$terrainType] ?? 0;
        
        return max(0.1, min(0.95, $baseProbability));
    }

    /**
     * Estimar recursos necesarios
     */
    private function estimateResources(float $area, int $fireRisk, string $terrainType): array
    {
        // Bomberos necesarios (1 por cada 0.5 km²)
        $firefighters = max(5, ceil($area / 0.5));
        
        // Vehículos (1 por cada 3 bomberos)
        $vehicles = max(2, ceil($firefighters / 3));
        
        // Helicópteros para áreas grandes
        $helicopters = $area > 5 ? ceil($area / 10) : 0;
        
        // Ajustar por riesgo
        if ($fireRisk > 70) {
            $firefighters = ceil($firefighters * 1.5);
            $vehicles = ceil($vehicles * 1.3);
            $helicopters += 1;
        }
        
        return [
            'firefighters' => $firefighters,
            'fire_trucks' => $vehicles,
            'helicopters' => $helicopters,
            'water_needed_liters' => round($area * 10000), // 10,000L por km²
            'estimated_cost_usd' => round($firefighters * 200 + $vehicles * 500 + $helicopters * 5000),
        ];
    }

    /**
     * Generar recomendaciones
     */
    private function generateRecommendations(
        int $fireRisk,
        string $terrainType,
        float $windSpeed,
        float $area
    ): array {
        $recommendations = [];
        
        if ($fireRisk > 70) {
            $recommendations[] = "⚠️ Riesgo CRÍTICO: Evacuación inmediata de zonas cercanas";
            $recommendations[] = "🚁 Solicitar apoyo aéreo urgente";
        } elseif ($fireRisk > 40) {
            $recommendations[] = "⚠️ Riesgo ALTO: Monitoreo constante requerido";
        }
        
        if ($windSpeed > 30) {
            $recommendations[] = "💨 Vientos fuertes: Priorizar cortafuegos en dirección del viento";
        }
        
        if ($terrainType === 'bosque_denso') {
            $recommendations[] = "🌲 Bosque denso: Crear líneas de contención amplias";
        }
        
        if ($area > 10) {
            $recommendations[] = "📏 Área extensa: Dividir zona en sectores de control";
        }
        
        $recommendations[] = "💧 Mantener provisiones de agua constantes";
        $recommendations[] = "📡 Establecer comunicación permanente entre equipos";
        
        return $recommendations;
    }

    /**
     * Obtener nivel de peligro
     */
    private function getDangerLevel(int $fireRisk): string
    {
        if ($fireRisk > 80) return 'EXTREMO';
        if ($fireRisk > 60) return 'MUY ALTO';
        if ($fireRisk > 40) return 'ALTO';
        if ($fireRisk > 20) return 'MODERADO';
        return 'BAJO';
    }

    /**
     * Obtener tasa de propagación
     */
    private function getPropagationRate(float $speed): string
    {
        if ($speed > 2) return 'MUY RÁPIDA';
        if ($speed > 1) return 'RÁPIDA';
        if ($speed > 0.5) return 'MODERADA';
        return 'LENTA';
    }

    /**
     * Calcular confianza de la predicción
     */
    private function calculateConfidence(
        FocosIncendio $foco,
        float $humidity,
        float $windSpeed
    ): float {
        $confidence = 0.85; // base
        
        // Reducir si falta información
        if (!$foco->coordenadas) $confidence -= 0.3;
        if (!$foco->intensidad) $confidence -= 0.1;
        
        // Reducir con condiciones extremas
        if ($humidity < 20 || $humidity > 90) $confidence -= 0.1;
        if ($windSpeed > 50) $confidence -= 0.15;
        
        return max(0.3, min(0.95, $confidence));
    }
}
