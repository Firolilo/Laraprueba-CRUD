<?php

namespace App\Http\Controllers;

use App\Models\Simulacione;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SimulacioneRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SimulacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $simulaciones = Simulacione::paginate();

        return view('simulacione.index', compact('simulaciones'))
            ->with('i', ($request->input('page', 1) - 1) * $simulaciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $simulacione = new Simulacione();

        return view('simulacione.create', compact('simulacione'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SimulacioneRequest $request): RedirectResponse
    {
        Simulacione::create($request->validated());

        return Redirect::route('simulaciones.index')
            ->with('success', 'Simulacione created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $simulacione = Simulacione::find($id);

        return view('simulacione.show', compact('simulacione'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $simulacione = Simulacione::find($id);

        return view('simulacione.edit', compact('simulacione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SimulacioneRequest $request, Simulacione $simulacione): RedirectResponse
    {
        $simulacione->update($request->validated());

        return Redirect::route('simulaciones.index')
            ->with('success', 'Simulacione updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Simulacione::find($id)->delete();

        return Redirect::route('simulaciones.index')
            ->with('success', 'Simulacione deleted successfully');
    }
}
