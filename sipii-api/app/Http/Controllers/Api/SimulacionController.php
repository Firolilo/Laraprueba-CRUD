<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SimulacioneResource;
use App\Models\Simulacione;
use Illuminate\Http\Request;

class SimulacionController extends Controller
{
    /**
     * Display a listing of simulaciones.
     */
    public function index()
    {
        $simulaciones = Simulacione::with('administrador')->latest()->get();
        return SimulacioneResource::collection($simulaciones);
    }

    /**
     * Store a newly created simulacion.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'admin_id' => 'required|exists:administradors,id',
            'parameters' => 'required|array',
            'parameters.temperature' => 'required|numeric',
            'parameters.humidity' => 'required|numeric',
            'parameters.windSpeed' => 'required|numeric',
            'parameters.windDirection' => 'required|numeric',
            'parameters.simulationSpeed' => 'required|numeric',
            'initial_fires' => 'required|array',
            'history' => 'required|array',
        ]);

        $validated['parameters'] = json_encode($validated['parameters']);
        $validated['initial_fires'] = json_encode($validated['initial_fires']);
        $validated['history'] = json_encode($validated['history']);
        
        $simulacion = Simulacione::create($validated);
        
        return new SimulacioneResource($simulacion->load('administrador'));
    }

    /**
     * Display the specified simulacion.
     */
    public function show(Simulacione $simulacion)
    {
        return new SimulacioneResource($simulacion->load('administrador'));
    }

    /**
     * Remove the specified simulacion.
     */
    public function destroy(Simulacione $simulacion)
    {
        $simulacion->delete();
        return response()->json(['message' => 'Simulación eliminada exitosamente'], 200);
    }
}
