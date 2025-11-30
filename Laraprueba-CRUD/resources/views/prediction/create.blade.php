@extends('layouts.app')

@section('subtitle', 'Generar Predicción')
@section('content_header_title', 'Predicciones')
@section('content_header_subtitle', 'Generar Nueva Predicción')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Nueva Predicción de Propagación" theme="success" icon="fas fa-chart-line">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('predictions.index') }}"/>
                    </x-slot>

                    <form method="POST" action="{{ route('predictions.store') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @include('prediction.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @stack('js')
@endsection
