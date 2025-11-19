@extends('adminlte::page')

@section('title', 'Crear Tipo de Biomasa')

@section('content_header')
    <h1>Crear Tipo de Biomasa</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear') }} Tipo de Biomasa</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('tipo-biomasas.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('tipo-biomasa.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
