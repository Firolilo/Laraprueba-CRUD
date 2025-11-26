<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PredictionResource;
use App\Models\Prediction;
use App\Models\FocosIncendio;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    /**
     * Display a listing of predictions.
     */
    public function index()
    {
        $predictions = Prediction::with('focoIncendio')->latest()->get();
        return PredictionResource::collection($predictions);
    }

    /**
     * Store a newly created prediction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'foco_incendio_id' => 'required|exists:focos_incendios,id',
            'temperature' => 'nullable|numeric|min:0|max:60',
            'humidity' => 'nullable|numeric|min:0|max:100',
            'wind_speed' => 'nullable|numeric|min:0|max:200',
            'wind_direction' => 'nullable|integer|min:0|max:360',
            'prediction_hours' => 'nullable|integer|min:1|max:72',
            'terrain_type' => 'nullable|string',
        ]);

        $foco = FocosIncendio::findOrFail($validated['foco_incendio_id']);
        
        // Valores por defecto si no se proporcionan
        $temperature = $validated['temperature'] ?? 25;
        $humidity = $validated['humidity'] ?? 50;
        $windSpeed = $validated['wind_speed'] ?? 10;
        $windDirection = $validated['wind_direction'] ?? 0;
        $predictionHours = $validated['prediction_hours'] ?? 24;
        $terrainType = $validated['terrain_type'] ?? 'mixto';
        
        // Usar un método estático o crear servicio para generar predicción
        // Por ahora, creamos directamente sin predicción completa
        $prediction = Prediction::create([
            'foco_incendio_id' => $foco->id,
            'predicted_at' => now(),
            'path' => json_encode([]), // Será implementado
            'meta' => json_encode([
                'temperature' => $temperature,
                'humidity' => $humidity,
                'wind_speed' => $windSpeed,
                'wind_direction' => $windDirection,
                'prediction_hours' => $predictionHours,
                'terrain_type' => $terrainType,
            ]),
        ]);

        return new PredictionResource($prediction->load('focoIncendio'));
    }

    /**
     * Display the specified prediction.
     */
    public function show(Prediction $prediction)
    {
        return new PredictionResource($prediction->load('focoIncendio'));
    }

    /**
     * Remove the specified prediction.
     */
    public function destroy(Prediction $prediction)
    {
        $prediction->delete();
        return response()->json(['message' => 'Predicción eliminada exitosamente'], 200);
    }
}
