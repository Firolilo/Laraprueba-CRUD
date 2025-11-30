@extends('layouts.app')

@section('subtitle', 'Crear Voluntario')
@section('content_header_title', 'Voluntarios')
@section('content_header_subtitle', 'Crear Nuevo')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Crear Voluntario" theme="success" icon="fas fa-hands-helping">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('voluntarios.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('voluntarios.store') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @include('voluntario.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
