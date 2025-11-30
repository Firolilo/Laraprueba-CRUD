@extends('layouts.app')

@section('subtitle', 'Editar Administrador')
@section('content_header_title', 'Administradores')
@section('content_header_subtitle', 'Editar')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Editar Administrador: {{ $administrador->user->name }}" theme="warning" icon="fas fa-edit">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('administradores.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('administradores.update', $administrador->id) }}" role="form" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf
                        @include('administrador.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
