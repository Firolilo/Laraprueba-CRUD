@extends('adminlte::page')

@section('title', 'Ver Tipo de Biomasa')

@section('content_header')
    <h1>Ver Tipo de Biomasa</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Tipo de Biomasa</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('tipo-biomasas.index') }}"> {{ __('Regresar') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo de Biomasa:</strong>
                            {{ $tipoBiomasa->tipo_biomasa }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
