@extends('layouts.app')

@section('subtitle', 'Administradores')
@section('content_header_title', 'Gestión de Administradores')
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

                <x-adminlte-card title="Administradores" theme="primary" icon="fas fa-user-shield">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Crear Nuevo" icon="fas fa-plus" 
                            class="btn-sm" theme="success" href="{{ route('administradores.create') }}"/>
                    </x-slot>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Departamento</th>
                                    <th>Nivel de Acceso</th>
                                    <th>Activo</th>
                                    <th style="width: 240px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($administradores as $administrador)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $administrador->user->name }}</td>
                                        <td>{{ $administrador->user->email }}</td>
                                        <td>{{ $administrador->departamento }}</td>
                                        <td>{{ $administrador->nivel_acceso }}</td>
                                        <td>
                                            @if($administrador->activo)
                                                <span class="badge badge-success">Sí</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <x-adminlte-button icon="fas fa-eye" theme="info" 
                                                    href="{{ route('administradores.show', $administrador->id) }}" size="sm" title="Ver"/>
                                                <x-adminlte-button icon="fas fa-edit" theme="warning" 
                                                    href="{{ route('administradores.edit', $administrador->id) }}" size="sm" title="Editar"/>
                                                <form action="{{ route('administradores.destroy', $administrador->id) }}" method="POST" style="display: inline;" 
                                                    onsubmit="return confirm('¿Está seguro de eliminar este administrador?');">
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
                        {!! $administradores->withQueryString()->links() !!}
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
