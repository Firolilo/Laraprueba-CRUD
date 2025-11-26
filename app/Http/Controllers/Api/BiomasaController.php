<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BiomasaResource;
use App\Models\Biomasa;
use Illuminate\Http\Request;

class BiomasaController extends Controller
{
    /**
     * Display a listing of biomasas.
     */
    public function index()
    {
        $biomasas = Biomasa::with('tipoBiomasa', 'user')->latest()->get();
        return BiomasaResource::collection($biomasas);
    }

    /**
     * Store a newly created biomasa.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_biomasa_id' => 'required|exists:tipo_biomasas,id',
            'densidad' => 'required|in:Baja,Media,Alta',
            'coordenadas' => 'required|array|min:3',
            'coordenadas.*' => 'array|size:2',
            'area_m2' => 'required|numeric|min:0',
            'perimetro_m' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'fecha_reporte' => 'required|date',
        ]);

        $validated['coordenadas'] = json_encode($validated['coordenadas']);
        $validated['user_id'] = auth()->id();

        $biomasa = Biomasa::create($validated);
        
        return new BiomasaResource($biomasa->load('tipoBiomasa', 'user'));
    }

    /**
     * Display the specified biomasa.
     */
    public function show(Biomasa $biomasa)
    {
        return new BiomasaResource($biomasa->load('tipoBiomasa', 'user'));
    }

    /**
     * Update the specified biomasa.
     */
    public function update(Request $request, Biomasa $biomasa)
    {
        $validated = $request->validate([
            'tipo_biomasa_id' => 'sometimes|required|exists:tipo_biomasas,id',
            'densidad' => 'sometimes|required|in:Baja,Media,Alta',
            'coordenadas' => 'sometimes|required|array|min:3',
            'coordenadas.*' => 'array|size:2',
            'area_m2' => 'sometimes|required|numeric|min:0',
            'perimetro_m' => 'sometimes|required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'fecha_reporte' => 'sometimes|required|date',
        ]);

        if (isset($validated['coordenadas'])) {
            $validated['coordenadas'] = json_encode($validated['coordenadas']);
        }

        $biomasa->update($validated);
        
        return new BiomasaResource($biomasa->load('tipoBiomasa', 'user'));
    }

    /**
     * Remove the specified biomasa.
     */
    public function destroy(Biomasa $biomasa)
    {
        $biomasa->delete();
        return response()->json(['message' => 'Biomasa eliminada exitosamente'], 200);
    }
}
