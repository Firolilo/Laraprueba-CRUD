@extends('adminlte::page')

@section('template_title')
    {{ $user->name ?? __('Ver') . " " . __('Usuario') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Usuario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $user->name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Correo Electrónico:</strong>
                            {{ $user->email }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Teléfono:</strong>
                            {{ $user->telefono }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Cédula de identidad:</strong>
                            {{ $user->cedula_identidad }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
