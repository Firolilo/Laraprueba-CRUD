@extends('layouts.app')

@section('subtitle', 'Dashboard')
@section('content_header_title', 'Panel Principal')
@section('content_header_subtitle', 'Sistema de Prevención de Incendios')

@section('content_body')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Bienvenido al SIPII" theme="primary" icon="fas fa-home">
                <p>Bienvenido al <strong>Sistema Integral de Prevención de Incendios</strong>, <strong>{{ auth()->user()->name }}</strong>.</p>
                <p>
                    @if(auth()->user()->isAdministrador())
                        <span class="badge badge-danger"><i class="fas fa-user-shield"></i> Administrador</span>
                        Tienes acceso completo a todos los módulos del sistema.
                    @elseif(auth()->user()->isVoluntario())
                        <span class="badge badge-success"><i class="fas fa-hands-helping"></i> Voluntario</span>
                        Puedes crear biomasa, usar el simulador y consultar predicciones.
                    @endif
                </p>
            </x-adminlte-card>
        </div>
    </div>

    {{-- Módulos para TODOS los usuarios autenticados --}}
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <x-adminlte-small-box title="Biomasa" text="Observaciones y delimitación de áreas" 
                icon="fas fa-leaf" theme="success" url="{{ route('biomasas.index') }}" url-text="Ver biomasa"/>
        </div>

        <div class="col-lg-3 col-md-6">
            <x-adminlte-small-box title="Simulador" text="Simulador avanzado de incendios" 
                icon="fas fa-fire" theme="warning" url="{{ route('simulaciones.simulator') }}" url-text="Iniciar simulador"/>
        </div>

        <div class="col-lg-3 col-md-6">
            <x-adminlte-small-box title="Predicciones" text="Consultar predicciones de rutas" 
                icon="fas fa-chart-line" theme="purple" url="{{ route('predictions.index') }}" url-text="Ver predicciones"/>
        </div>
    </div>

    {{-- Módulos SOLO para ADMINISTRADORES --}}
    @if(auth()->user()->isAdministrador())
        <div class="row">
            <div class="col-12">
                <h5 class="text-muted"><i class="fas fa-user-shield"></i> Módulos de Administración</h5>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <x-adminlte-small-box title="Usuarios" text="Gestionar usuarios" 
                    icon="fas fa-users" theme="info" url="{{ route('users.index') }}" url-text="Ver usuarios"/>
            </div>

            <div class="col-lg-3 col-md-6">
                <x-adminlte-small-box title="Tipos de Biomasa" text="Catálogo de tipos" 
                    icon="fas fa-list" theme="olive" url="{{ route('tipo-biomasas.index') }}" url-text="Ver tipos"/>
            </div>

            <div class="col-lg-3 col-md-6">
                <x-adminlte-small-box title="Simulaciones" text="Ver y administrar simulaciones" 
                    icon="fas fa-play-circle" theme="orange" url="{{ route('simulaciones.index') }}" url-text="Ver simulaciones"/>
            </div>

            <div class="col-lg-3 col-md-6">
                <x-adminlte-small-box title="Focos de Incendio" text="Seguimiento de focos activos" 
                    icon="fas fa-fire" theme="danger" url="{{ route('focos-incendios.index') }}" url-text="Ver focos"/>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <x-adminlte-small-box title="Administradores" text="Gestionar administradores del sistema" 
                    icon="fas fa-user-shield" theme="primary" url="{{ route('administradores.index') }}" url-text="Ver administradores"/>
            </div>

            <div class="col-lg-3 col-md-6">
                <x-adminlte-small-box title="Voluntarios" text="Gestionar voluntarios registrados" 
                    icon="fas fa-hands-helping" theme="teal" url="{{ route('voluntarios.index') }}" url-text="Ver voluntarios"/>
            </div>
        </div>
    @endif
@stop

@section('css')
    {{-- Agrega CSS personalizado si lo necesitas --}}
@stop

@section('js')
    {{-- Agrega JS personalizado si lo necesitas --}}
@stop
