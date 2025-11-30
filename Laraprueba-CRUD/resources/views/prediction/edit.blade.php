@extends('layouts.app')

@section('subtitle', 'Editar Predicción')
@section('content_header_title', 'Predicciones')
@section('content_header_subtitle', 'Editar')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Editar Predicción" theme="warning" icon="fas fa-edit">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('predictions.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('predictions.update', $prediction->id) }}" role="form" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf
                        @include('prediction.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
