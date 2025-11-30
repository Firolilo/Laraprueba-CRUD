@extends('layouts.app')

@section('subtitle', 'Voluntarios')
@section('content_header_title', 'Gestión de Voluntarios')
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

                <x-adminlte-card title="Voluntarios" theme="teal" icon="fas fa-hands-helping">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Crear Nuevo" icon="fas fa-plus" 
                            class="btn-sm" theme="success" href="{{ route('voluntarios.create') }}"/>
                    </x-slot>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Ciudad</th>
                                    <th>Zona</th>
                                    <th>Dirección</th>
                                    <th style="width: 240px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($voluntarios as $voluntario)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $voluntario->user->name }}</td>
                                        <td>{{ $voluntario->user->email }}</td>
                                        <td>{{ $voluntario->ciudad }}</td>
                                        <td>{{ $voluntario->zona }}</td>
                                        <td>{{ $voluntario->direccion }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <x-adminlte-button icon="fas fa-eye" theme="info" 
                                                    href="{{ route('voluntarios.show', $voluntario->id) }}" size="sm" title="Ver"/>
                                                <x-adminlte-button icon="fas fa-edit" theme="warning" 
                                                    href="{{ route('voluntarios.edit', $voluntario->id) }}" size="sm" title="Editar"/>
                                                <form action="{{ route('voluntarios.destroy', $voluntario->id) }}" method="POST" style="display: inline;" 
                                                    onsubmit="return confirm('¿Está seguro de eliminar este voluntario?');">
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
                        {!! $voluntarios->withQueryString()->links() !!}
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
