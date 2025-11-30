@extends('layouts.app')

@section('subtitle', 'Tipos de Biomasa')
@section('content_header_title', 'Catálogo de Tipos de Biomasa')
@section('content_header_subtitle', 'Listado')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if ($message = Session::get('success'))
                    <x-adminlte-alert theme="success" dismissable>
                        {{ $message }}
                    </x-adminlte-alert>
                @endif

                <x-adminlte-card title="Tipos de Biomasa" theme="olive" icon="fas fa-list">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Crear Nuevo" icon="fas fa-plus" 
                            class="btn-sm" theme="success" href="{{ route('tipo-biomasas.create') }}"/>
                    </x-slot>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tipo de Biomasa</th>
                                    <th>Color</th>
                                    <th>Factor Propagación</th>
                                    <th style="width: 180px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipoBiomasas as $tipoBiomasa)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $tipoBiomasa->tipo_biomasa }}</td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $tipoBiomasa->color ?? '#4CAF50' }}; color: white;">
                                                {{ $tipoBiomasa->color ?? '#4CAF50' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $tipoBiomasa->modificador_intensidad ?? 1.0 }}x</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <x-adminlte-button icon="fas fa-eye" theme="info" 
                                                    href="{{ route('tipo-biomasas.show', $tipoBiomasa->id) }}" size="sm" title="Ver"/>
                                                <x-adminlte-button icon="fas fa-edit" theme="success" 
                                                    href="{{ route('tipo-biomasas.edit', $tipoBiomasa->id) }}" size="sm" title="Editar"/>
                                                <form action="{{ route('tipo-biomasas.destroy', $tipoBiomasa->id) }}" method="POST" style="display: inline;" 
                                                    onsubmit="return confirm('¿Está seguro de eliminar este tipo de biomasa?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-adminlte-button type="submit" icon="fas fa-trash" 
                                                        theme="danger" size="sm" title="Eliminar"/>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {!! $tipoBiomasas->withQueryString()->links() !!}
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
