@extends('layouts.app')

@section('subtitle', 'Crear Usuario')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Crear Nuevo')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Crear Usuario" theme="success" icon="fas fa-user-plus">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('users.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('users.store') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @include('user.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
