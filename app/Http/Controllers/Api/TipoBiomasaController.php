<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TipoBiomasaResource;
use App\Models\TipoBiomasa;
use Illuminate\Http\Request;

class TipoBiomasaController extends Controller
{
    /**
     * Display a listing of tipos de biomasa.
     */
    public function index()
    {
        $tipos = TipoBiomasa::withCount('biomasas')->get();
        return TipoBiomasaResource::collection($tipos);
    }

    /**
     * Store a newly created tipo de biomasa.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_biomasa' => 'required|string|max:255|unique:tipo_biomasas',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'modificador_intensidad' => 'required|numeric|between:0.5,2.0',
        ]);
        
        $tipo = TipoBiomasa::create($validated);
        
        return new TipoBiomasaResource($tipo);
    }

    /**
     * Display the specified tipo de biomasa.
     */
    public function show(TipoBiomasa $tipoBiomasa)
    {
        return new TipoBiomasaResource($tipoBiomasa);
    }

    /**
     * Update the specified tipo de biomasa.
     */
    public function update(Request $request, TipoBiomasa $tipoBiomasa)
    {
        $validated = $request->validate([
            'tipo_biomasa' => 'sometimes|required|string|max:255|unique:tipo_biomasas,tipo_biomasa,' . $tipoBiomasa->id,
            'color' => 'sometimes|required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'modificador_intensidad' => 'sometimes|required|numeric|between:0.5,2.0',
        ]);
        
        $tipoBiomasa->update($validated);
        
        return new TipoBiomasaResource($tipoBiomasa);
    }

    /**
     * Remove the specified tipo de biomasa.
     */
    public function destroy(TipoBiomasa $tipoBiomasa)
    {
        $tipoBiomasa->delete();
        return response()->json(['message' => 'Tipo de biomasa eliminado exitosamente'], 200);
    }
}
