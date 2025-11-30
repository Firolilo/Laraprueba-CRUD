@extends('adminlte::page')

@section('title', 'Generar Predicción')

@section('content_header')
    <h1><i class="fas fa-chart-line text-primary"></i> Generar Predicción de Propagación</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Nueva Predicción</h3>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('predictions.store') }}" role="form" enctype="multipart/form-data">
                            @csrf
                            @include('prediction.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
    @stack('js')
@endsection
