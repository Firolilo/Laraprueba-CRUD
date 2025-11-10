<?php

namespace App\Http\Controllers;

use App\Models\Biomasa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BiomasaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BiomasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $biomasas = Biomasa::paginate();

        return view('biomasa.index', compact('biomasas'))
            ->with('i', ($request->input('page', 1) - 1) * $biomasas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $biomasa = new Biomasa();

        return view('biomasa.create', compact('biomasa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BiomasaRequest $request): RedirectResponse
    {
        Biomasa::create($request->validated());

        return Redirect::route('biomasas.index')
            ->with('success', 'Biomasa created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $biomasa = Biomasa::find($id);

        return view('biomasa.show', compact('biomasa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $biomasa = Biomasa::find($id);

        return view('biomasa.edit', compact('biomasa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BiomasaRequest $request, Biomasa $biomasa): RedirectResponse
    {
        $biomasa->update($request->validated());

        return Redirect::route('biomasas.index')
            ->with('success', 'Biomasa updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Biomasa::find($id)->delete();

        return Redirect::route('biomasas.index')
            ->with('success', 'Biomasa deleted successfully');
    }
}
