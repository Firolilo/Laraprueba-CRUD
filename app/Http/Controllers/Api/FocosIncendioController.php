<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FocosIncendioResource;
use App\Models\FocosIncendio;
use Illuminate\Http\Request;

class FocosIncendioController extends Controller
{
    /**
     * Display a listing of focos de incendio.
     */
    public function index()
    {
        $focos = FocosIncendio::with('predictions')->latest('fecha')->get();
        return FocosIncendioResource::collection($focos);
    }

    /**
     * Store a newly created foco de incendio.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'ubicacion' => 'required|string|max:255',
            'coordenadas' => 'required',
            'intensidad' => 'required|numeric|min:0|max:10',
        ]);

        // Parse coordenadas if it's a string
        if (is_string($validated['coordenadas'])) {
            $validated['coordenadas'] = json_decode($validated['coordenadas'], true);
        }
        
        $foco = FocosIncendio::create($validated);
        
        return new FocosIncendioResource($foco);
    }

    /**
     * Display the specified foco de incendio.
     */
    public function show(FocosIncendio $focosIncendio)
    {
        return new FocosIncendioResource($focosIncendio->load('predictions'));
    }

    /**
     * Update the specified foco de incendio.
     */
    public function update(Request $request, FocosIncendio $focosIncendio)
    {
        $validated = $request->validate([
            'fecha' => 'sometimes|required|date',
            'ubicacion' => 'sometimes|required|string|max:255',
            'coordenadas' => 'sometimes|required|array|size:2',
            'coordenadas.0' => 'numeric|between:-90,90',
            'coordenadas.1' => 'numeric|between:-180,180',
            'intensidad' => 'sometimes|required|numeric|min:0|max:10',
        ]);

        if (isset($validated['coordenadas'])) {
            $validated['coordenadas'] = json_encode($validated['coordenadas']);
        }
        
        $focosIncendio->update($validated);
        
        return new FocosIncendioResource($focosIncendio);
    }

    /**
     * Remove the specified foco de incendio.
     */
    public function destroy(FocosIncendio $focosIncendio)
    {
        $focosIncendio->delete();
        return response()->json(['message' => 'Foco de incendio eliminado exitosamente'], 200);
    }
}
