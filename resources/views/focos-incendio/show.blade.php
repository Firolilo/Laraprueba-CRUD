@extends('adminlte::page')

@section('template_title')
    {{ $focosIncendio->name ?? __('Show') . " " . __('Focos Incendio') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Focos Incendio</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('focos-incendios.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <dl class="row mb-0">
                            <dt class="col-sm-3">Fecha</dt>
                            <dd class="col-sm-9">{{ optional($focosIncendio->fecha)->format('Y-m-d H:i') }}</dd>

                            <dt class="col-sm-3">Ubicación</dt>
                            <dd class="col-sm-9">{{ $focosIncendio->ubicacion }}</dd>

                            <dt class="col-sm-3">Intensidad</dt>
                            <dd class="col-sm-9">{{ $focosIncendio->intensidad }}</dd>

                            <dt class="col-sm-3">Coordenadas</dt>
                            <dd class="col-sm-9">{{ $focosIncendio->coordenadas ? json_encode($focosIncendio->coordenadas) : '' }}</dd>
                            
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
