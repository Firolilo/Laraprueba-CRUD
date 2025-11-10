<?php

namespace App\Http\Controllers;

use App\Models\FocosIncendio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\FocosIncendioRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FocosIncendioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $focosIncendios = FocosIncendio::paginate();

        return view('focos-incendio.index', compact('focosIncendios'))
            ->with('i', ($request->input('page', 1) - 1) * $focosIncendios->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $focosIncendio = new FocosIncendio();

        return view('focos-incendio.create', compact('focosIncendio'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FocosIncendioRequest $request): RedirectResponse
    {
        FocosIncendio::create($request->validated());

        return Redirect::route('focos-incendios.index')
            ->with('success', 'FocosIncendio created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $focosIncendio = FocosIncendio::find($id);

        return view('focos-incendio.show', compact('focosIncendio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $focosIncendio = FocosIncendio::find($id);

        return view('focos-incendio.edit', compact('focosIncendio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FocosIncendioRequest $request, FocosIncendio $focosIncendio): RedirectResponse
    {
        $focosIncendio->update($request->validated());

        return Redirect::route('focos-incendios.index')
            ->with('success', 'FocosIncendio updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        FocosIncendio::find($id)->delete();

        return Redirect::route('focos-incendios.index')
            ->with('success', 'FocosIncendio deleted successfully');
    }
}
