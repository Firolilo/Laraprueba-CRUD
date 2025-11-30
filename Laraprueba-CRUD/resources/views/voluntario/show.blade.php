@extends('adminlte::page')

@section('template_title')
    {{ $voluntario->user->name ?? __('Ver') . " Voluntario" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Voluntario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('voluntarios.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $voluntario->user->name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Email:</strong>
                            {{ $voluntario->user->email }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Dirección:</strong>
                            {{ $voluntario->direccion }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Ciudad:</strong>
                            {{ $voluntario->ciudad }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Zona:</strong>
                            {{ $voluntario->zona }}
                        </div>
                        @if($voluntario->notas)
                        <div class="form-group mb-2 mb20">
                            <strong>Notas:</strong>
                            <p>{{ $voluntario->notas }}</p>
                        </div>
                        @endif
                        <div class="form-group mb-2 mb20">
                            <strong>Creado:</strong>
                            {{ $voluntario->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Actualizado:</strong>
                            {{ $voluntario->updated_at->format('d/m/Y H:i') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
