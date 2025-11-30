@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Panel Principal</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p>Bienvenido al panel principal usando <strong>AdminLTE</strong>.</p>
                    <p>Desde aquí puedes empezar a agregar widgets, menús y contenido específico de tu aplicación.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                <div class="small-box bg-info text-white p-3">
                    <div class="inner">
                        <h4>Usuarios</h4>
                        <p>Gestionar usuarios</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('biomasas.index') }}" class="text-decoration-none">
                <div class="small-box bg-success text-white p-3">
                    <div class="inner">
                        <h4>Biomasa</h4>
                        <p>Observaciones y delimitación de áreas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('tipo-biomasas.index') }}" class="text-decoration-none">
                <div class="small-box bg-olive text-white p-3">
                    <div class="inner">
                        <h4>Tipos de Biomasa</h4>
                        <p>Catálogo de tipos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('simulaciones.simulator') }}" class="text-decoration-none">
                <div class="small-box bg-warning text-white p-3">
                    <div class="inner">
                        <h4>Simulador</h4>
                        <p>Simulador avanzado de incendios</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fire"></i>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('simulaciones.index') }}" class="text-decoration-none">
                <div class="small-box bg-orange text-white p-3">
                    <div class="inner">
                        <h4>Simulaciones</h4>
                        <p>Ver y administrar simulaciones</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-play-circle"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('focos-incendios.index') }}" class="text-decoration-none">
                <div class="small-box bg-danger text-white p-3">
                    <div class="inner">
                        <h4>Focos de incendio</h4>
                        <p>Seguimiento de focos (coordenadas, intensidad)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fire"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('predictions.index') }}" class="text-decoration-none">
                <div class="small-box bg-purple text-white p-3">
                    <div class="inner">
                        <h4>Predicciones</h4>
                        <p>Predicciones de rutas de focos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('administradores.index') }}" class="text-decoration-none">
                <div class="small-box bg-primary text-white p-3">
                    <div class="inner">
                        <h4>Administradores</h4>
                        <p>Gestionar administradores del sistema</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('voluntarios.index') }}" class="text-decoration-none">
                <div class="small-box bg-teal text-white p-3">
                    <div class="inner">
                        <h4>Voluntarios</h4>
                        <p>Gestionar voluntarios registrados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
@stop

@section('css')
    {{-- Agrega CSS personalizado si lo necesitas --}}
@stop

@section('js')
    {{-- Agrega JS personalizado si lo necesitas --}}
@stop
