@extends('adminlte::page')

@section('title', 'Editar Predicción')

@section('content_header')
    <h1>Editar Predicción</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Predicción</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('predictions.update', $prediction->id) }}" role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('prediction.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
