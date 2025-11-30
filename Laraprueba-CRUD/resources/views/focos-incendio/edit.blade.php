@extends('adminlte::page')

@section('template_title')
    {{ __('Actualizar') }} Foco de Incendio
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Foco de Incendio</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('focos-incendios.update', $focosIncendio->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('focos-incendio.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    @stack('css')
@endsection

@section('js')
    @stack('js')
@endsection
