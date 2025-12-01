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

                <x-adminlte-card title="Focos de Incendio" theme="danger" icon="fas fa-fire">
                    <x-slot name="toolsSlot">
                        <a href="{{ route('focos-incendios.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Crear Nuevo
                        </a>
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
                                                <a href="{{ route('focos-incendios.show', $focosIncendio->id) }}" class="btn btn-info btn-sm" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('focos-incendios.edit', $focosIncendio->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('focos-incendios.destroy', $focosIncendio->id) }}" method="POST" style="display: inline;" 
                                                    onsubmit="return confirm('¿Está seguro de eliminar este foco?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
