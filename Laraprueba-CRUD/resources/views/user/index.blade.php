@extends('layouts.app')

@section('subtitle', 'Usuarios')
@section('content_header_title', 'Gestión de Usuarios')
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

                <x-adminlte-card title="Usuarios" theme="primary" icon="fas fa-users">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Crear Nuevo" icon="fas fa-plus" 
                            class="btn-sm" theme="success" href="{{ route('users.create') }}"/>
                    </x-slot>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nombre</th>
                                    <th>Correo Electrónico</th>
                                    <th>Teléfono</th>
                                    <th>C.I.</th>
                                    <th style="width: 180px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->telefono }}</td>
                                        <td>{{ $user->cedula_identidad }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <x-adminlte-button icon="fas fa-eye" theme="info" 
                                                    href="{{ route('users.show', $user->id) }}" size="sm" title="Ver"/>
                                                <x-adminlte-button icon="fas fa-edit" theme="success" 
                                                    href="{{ route('users.edit', $user->id) }}" size="sm" title="Editar"/>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" 
                                                    onsubmit="return confirm('¿Está seguro de eliminar este usuario?');">
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
                        {!! $users->withQueryString()->links() !!}
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
