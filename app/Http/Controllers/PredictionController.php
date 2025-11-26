<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\FocosIncendio;
use App\Models\Biomasa;
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
        $foco = $prediction->focoIncendio;
        
        // Cargar biomasas para mostrar en el mapa
        $biomasas = Biomasa::with('tipoBiomasa')
            ->whereNotNull('coordenadas')
            ->get()
            ->map(function ($biomasa) {
                if (is_string($biomasa->coordenadas)) {
                    $biomasa->coordenadas = json_decode($biomasa->coordenadas, true);
                }
                return $biomasa;
            });

        return view('prediction.show', compact('prediction', 'foco', 'biomasas'));
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
        // Parsear coordenadas si están en JSON
        $coords = is_string($foco->coordenadas) ? json_decode($foco->coordenadas, true) : $foco->coordenadas;
        $startLat = (float) $coords[0];
        $startLng = (float) $coords[1];
        $intensity = (float) ($foco->intensidad ?? 5);

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
        
        // Factores de crecimiento de intensidad
        $biomassAvailability = 1.0; // Disponibilidad inicial de combustible (100%)
        
        // Contador para detectar extinción del fuego
        $lowIntensityCount = 0; // Contador de horas consecutivas en intensidad 1
        $fireExtinguished = false; // Flag para marcar si el fuego se extinguió
        
        // Tracking de biomasas atravesadas
        $biomasasEncountered = [];

        for ($hour = 0; $hour <= $hours; $hour++) {
            // Detectar si el fuego está en una zona de biomasa
            $biomasaData = $this->getBiomasaModifier($currentLat, $currentLng);
            $biomasaModifier = $biomasaData['modifier'];
            
            // Registrar biomasa encontrada
            if ($biomasaData['inside_biomasa'] && !in_array($biomasaData['biomasa_id'], array_column($biomasasEncountered, 'id'))) {
                $biomasasEncountered[] = [
                    'id' => $biomasaData['biomasa_id'],
                    'tipo' => $biomasaData['tipo_biomasa'],
                    'modifier' => $biomasaModifier,
                    'entered_at_hour' => $hour,
                ];
            }
            
            // Si el fuego ya se extinguió, mantener el último estado sin movimiento
            if ($fireExtinguished) {
                $path[] = [
                    'hour' => $hour,
                    'lat' => round($currentLat, 6),
                    'lng' => round($currentLng, 6),
                    'intensity' => 1.0,
                    'spread_radius_km' => round($radius, 3),
                    'affected_area_km2' => round($area, 3),
                    'perimeter_km' => round($perimeter, 2),
                    'extinguished' => true,
                ];
                continue;
            }
            
            // MODELO REALISTA DE INTENSIDAD
            // La intensidad aumenta o se mantiene según condiciones, luego decrece por falta de combustible
            
            if ($hour <= $hours * 0.7) {
                // Fase de crecimiento/estabilidad (primeras 70% de horas)
                
                // Factor de temperatura: más calor = más intensidad
                $tempFactor = ($temperature > 30) ? (1 + ($temperature - 30) / 100) : 1.0;
                
                // Factor de humedad: menos humedad = más intensidad
                $humidityFactor = (100 - $humidity) / 100;
                
                // Factor de viento: más viento = más intensidad (oxigenación)
                $windFactor = 1 + ($windSpeed / 50);
                
                // La intensidad puede CRECER en condiciones favorables
                $intensityGrowth = $tempFactor * (0.5 + $humidityFactor * 0.5) * $windFactor * $terrainFactor;
                
                // APLICAR MODIFICADOR DE BIOMASA
                // Un bosque seco (modifier > 1.0) hace que el fuego crezca más rápido
                // Pastizal húmedo (modifier < 1.0) ralentiza el crecimiento
                $intensityGrowth *= $biomasaModifier;
                
                // Limitar crecimiento (no puede superar 10)
                $currentIntensity = min(10, $intensity * $intensityGrowth * (1 + $hour * 0.03));
                
            } else {
                // Fase de declive (últimas 30% de horas) - combustible agotándose
                $declineRate = ($hour - ($hours * 0.7)) / ($hours * 0.3);
                $biomassAvailability = 1 - ($declineRate * 0.6); // Combustible se reduce
                
                // El modificador de biomasa también afecta qué tan rápido se agota el combustible
                // Biomasa densa (modifier > 1.0) = más combustible disponible = declive más lento
                $biomasaDeclineFactor = 1.0 / max(0.5, $biomasaModifier);
                $biomassAvailability = max(0, $biomassAvailability * $biomasaDeclineFactor);
                
                $currentIntensity = max(1, $currentIntensity * (0.5 + $biomassAvailability * 0.5));
            }
            
            // Variación aleatoria para simular fluctuaciones naturales
            $randomVariation = 1 + (rand(-10, 10) / 100);
            $currentIntensity = min(10, max(1, $currentIntensity * $randomVariation));
            
            // Verificar si la intensidad está en 1 (fuego muy débil)
            if (round($currentIntensity, 1) <= 1.0) {
                $lowIntensityCount++;
                
                // Si ha estado en intensidad 1 por más de 3 horas consecutivas, el fuego se extingue
                if ($lowIntensityCount > 3) {
                    $fireExtinguished = true;
                    $currentIntensity = 1.0;
                    
                    // El fuego no se mueve más
                    $path[] = [
                        'hour' => $hour,
                        'lat' => round($currentLat, 6),
                        'lng' => round($currentLng, 6),
                        'intensity' => 1.0,
                        'spread_radius_km' => round($radius, 3),
                        'affected_area_km2' => round($area, 3),
                        'perimeter_km' => round($perimeter, 2),
                        'extinguished' => true,
                    ];
                    continue;
                }
            } else {
                // Si la intensidad sube, resetear el contador
                $lowIntensityCount = 0;
            }
            
            // Calcular desplazamiento basado en viento y variación aleatoria
            $mainDirection = $windRad;
            $lateralSpread = 0.3; // propagación lateral
            
            // Distancia recorrida en esta hora (en grados)
            // Aumenta con intensidad y velocidad del viento
            $speedMultiplier = 1 + ($currentIntensity / 10) + ($windSpeed / 30);
            $distance = ($spreadSpeed / 111) * $speedMultiplier * (0.8 + ($hour * 0.05));
            
            // Componente principal (dirección del viento)
            $latOffset = $distance * cos($mainDirection) * (0.8 + rand(0, 40) / 100);
            $lngOffset = $distance * sin($mainDirection) * (0.8 + rand(0, 40) / 100);
            
            // Añadir propagación lateral (más caótica con alta intensidad)
            $lateralOffset = $distance * $lateralSpread * (rand(-50, 50) / 100) * ($currentIntensity / 5);
            $latOffset += $lateralOffset * sin($mainDirection);
            $lngOffset += $lateralOffset * cos($mainDirection);

            $currentLat += $latOffset;
            $currentLng += $lngOffset;

            // Calcular área afectada (crece exponencialmente con intensidad)
            $radius = $spreadSpeed * sqrt($hour + 1) * ($currentIntensity / 5); // km
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
                'extinguished' => false,
                'biomasa' => $biomasaData['inside_biomasa'] ? [
                    'tipo' => $biomasaData['tipo_biomasa'],
                    'modifier' => $biomasaData['modifier'],
                    'densidad' => $biomasaData['densidad'],
                ] : null,
            ];
        }

        // Punto final predicho
        $finalPoint = end($path);
        
        // Determinar si el fuego se extinguió antes del tiempo predicho
        $actualDuration = $fireExtinguished ? ($hour - 1) : $hours;

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
            
            // Trayectoria completa para el mapa interactivo
            'trajectory' => $path,
            
            // Información de biomasas atravesadas
            'biomasas_encountered' => $biomasasEncountered,
            'total_biomasas_crossed' => count($biomasasEncountered),
            
            // Información de extinción
            'fire_extinguished' => $fireExtinguished,
            'actual_duration_hours' => $actualDuration,
            'extinguished_early' => $fireExtinguished && $actualDuration < $hours,
            
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

    /**
     * Detectar biomasa en la ubicación actual del fuego
     * Retorna el modificador de intensidad de la biomasa (1.0 si no hay biomasa)
     */
    private function getBiomasaModifier(float $lat, float $lng): array
    {
        // Cargar todas las biomasas con sus tipos
        $biomasas = Biomasa::with('tipoBiomasa')
            ->whereNotNull('coordenadas')
            ->get();

        foreach ($biomasas as $biomasa) {
            // Parsear coordenadas si es string
            $coords = is_string($biomasa->coordenadas) 
                ? json_decode($biomasa->coordenadas, true) 
                : $biomasa->coordenadas;

            if (!$coords || !is_array($coords) || count($coords) < 3) {
                continue;
            }

            // Verificar si el punto está dentro del polígono
            if ($this->isPointInPolygon($lat, $lng, $coords)) {
                $modifier = floatval($biomasa->tipoBiomasa->modificador_intensidad ?? 1.0);
                return [
                    'inside_biomasa' => true,
                    'biomasa_id' => $biomasa->id,
                    'tipo_biomasa' => $biomasa->tipoBiomasa->tipo_biomasa ?? 'Desconocido',
                    'modifier' => $modifier,
                    'densidad' => $biomasa->densidad,
                ];
            }
        }

        // No está en ninguna biomasa
        return [
            'inside_biomasa' => false,
            'biomasa_id' => null,
            'tipo_biomasa' => null,
            'modifier' => 1.0,
            'densidad' => null,
        ];
    }

    /**
     * Algoritmo Ray Casting para detectar si un punto está dentro de un polígono
     * @param float $lat Latitud del punto
     * @param float $lng Longitud del punto
     * @param array $polygon Array de coordenadas [[lat, lng], [lat, lng], ...]
     * @return bool True si el punto está dentro del polígono
     */
    private function isPointInPolygon(float $lat, float $lng, array $polygon): bool
    {
        $numVertices = count($polygon);
        $inside = false;

        for ($i = 0, $j = $numVertices - 1; $i < $numVertices; $j = $i++) {
            $xi = floatval($polygon[$i][0]); // lat
            $yi = floatval($polygon[$i][1]); // lng
            $xj = floatval($polygon[$j][0]); // lat
            $yj = floatval($polygon[$j][1]); // lng

            $intersect = (($yi > $lng) != ($yj > $lng))
                && ($lat < ($xj - $xi) * ($lng - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }
}
