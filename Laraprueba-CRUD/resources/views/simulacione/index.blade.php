@extends('layouts.app')

@section('subtitle', 'Simulaciones')
@section('content_header_title', 'Simulaciones de Incendios')
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

                <x-adminlte-card title="Simulaciones" theme="orange" icon="fas fa-play-circle">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Simulador Avanzado" icon="fas fa-fire" 
                            class="btn-sm" theme="warning" href="{{ route('simulaciones.simulator') }}"/>
                        <x-adminlte-button label="Crear Nueva" icon="fas fa-plus" 
                            class="btn-sm" theme="success" href="{{ route('simulaciones.create') }}"/>
                    </x-slot>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nombre</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Focos Activos</th>
                                    <th style="width: 180px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($simulaciones as $simulacione)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $simulacione->nombre }}</td>
                                        <td>{{ optional($simulacione->fecha)->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $simulacione->estado === 'activa' ? 'success' : 'secondary' }}">
                                                {{ $simulacione->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">{{ $simulacione->focos_activos }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <x-adminlte-button icon="fas fa-eye" theme="info" 
                                                    href="{{ route('simulaciones.show', $simulacione->id) }}" size="sm" title="Ver"/>
                                                <x-adminlte-button icon="fas fa-edit" theme="success" 
                                                    href="{{ route('simulaciones.edit', $simulacione->id) }}" size="sm" title="Editar"/>
                                                <form action="{{ route('simulaciones.destroy', $simulacione->id) }}" method="POST" style="display: inline;" 
                                                    onsubmit="return confirm('¿Está seguro de eliminar esta simulación?');">
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
                        {!! $simulaciones->withQueryString()->links() !!}
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
