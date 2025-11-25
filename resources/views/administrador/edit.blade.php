@extends('adminlte::page')

@section('template_title')
    {{ __('Actualizar') }} Administrador
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Administrador</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('administradores.update', $administrador->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf
                            @include('administrador.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
