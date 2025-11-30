@extends('layouts.app')

@section('subtitle', 'Focos de Incendio')
@section('content_header_title', 'Gestión de Focos de Incendio')
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

                <x-adminlte-card title="Focos de Incendios" theme="danger" icon="fas fa-fire">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Crear Nuevo" icon="fas fa-plus" 
                            class="btn-sm" theme="success" href="{{ route('focos-incendios.create') }}"/>
                    </x-slot>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Fecha</th>
                                    <th>Ubicación</th>
                                    <th>Coordenadas</th>
                                    <th>Intensidad</th>
                                    <th style="width: 240px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($focosIncendios as $focosIncendio)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ optional($focosIncendio->fecha)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $focosIncendio->ubicacion }}</td>
                                        <td>
                                            @if($focosIncendio->coordenadas)
                                                <small class="text-muted">
                                                    Lat: {{ $focosIncendio->coordenadas[0] }}<br>
                                                    Lng: {{ $focosIncendio->coordenadas[1] }}
                                                </small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $focosIncendio->intensidad > 7 ? 'danger' : ($focosIncendio->intensidad > 4 ? 'warning' : 'info') }}">
                                                {{ $focosIncendio->intensidad }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <x-adminlte-button icon="fas fa-eye" theme="info" 
                                                    href="{{ route('focos-incendios.show', $focosIncendio->id) }}" size="sm" title="Ver"/>
                                                <x-adminlte-button icon="fas fa-edit" theme="warning" 
                                                    href="{{ route('focos-incendios.edit', $focosIncendio->id) }}" size="sm" title="Editar"/>
                                                <form action="{{ route('focos-incendios.destroy', $focosIncendio->id) }}" method="POST" style="display: inline;" 
                                                    onsubmit="return confirm('¿Está seguro de eliminar este foco?');">
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
                        {!! $focosIncendios->withQueryString()->links() !!}
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
