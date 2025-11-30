@extends('layouts.app')

@section('subtitle', 'Crear Administrador')
@section('content_header_title', 'Administradores')
@section('content_header_subtitle', 'Crear Nuevo')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Crear Administrador" theme="success" icon="fas fa-user-shield">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('administradores.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('administradores.store') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @include('administrador.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
