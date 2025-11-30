@extends('layouts.app')

@section('subtitle', 'Crear Tipo de Biomasa')
@section('content_header_title', 'Tipos de Biomasa')
@section('content_header_subtitle', 'Crear Nuevo')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Crear Tipo de Biomasa" theme="success" icon="fas fa-leaf">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('tipo-biomasas.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('tipo-biomasas.store') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @include('tipo-biomasa.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
