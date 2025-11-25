@extends('adminlte::page')

@section('title', 'Resultado de Predicción')

@section('content_header')
    <h1><i class="fas fa-chart-area text-success"></i> Resultado de Predicción</h1>
@stop

@section('content')
@php
    $meta = $prediction->meta ?? [];
    $inputParams = $meta['input_parameters'] ?? [];
    $finalPos = $meta['final_position'] ?? [];
    $resources = $meta['estimated_resources'] ?? [];
    $recommendations = $meta['recommendations'] ?? [];
@endphp

<div class="container-fluid">
    <!-- Resumen General -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Información General</h3>
                    <div class="card-tools">
                        <a href="{{ route('predictions.index') }}" class="btn btn-tool">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">Foco de Incendio:</dt>
                                <dd class="col-sm-7">
                                    <strong>{{ $prediction->focoIncendio->ubicacion ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">
                                        Fecha: {{ $prediction->focoIncendio->fecha?->format('d/m/Y H:i') }}<br>
                                        Intensidad Inicial: {{ $inputParams['initial_intensity'] ?? 'N/A' }}
                                    </small>
                                </dd>
                                
                                <dt class="col-sm-5">Predicción Generada:</dt>
                                <dd class="col-sm-7">{{ $prediction->predicted_at?->format('d/m/Y H:i:s') }}</dd>
                                
                                <dt class="col-sm-5">Horizonte Temporal:</dt>
                                <dd class="col-sm-7"><strong>{{ $inputParams['prediction_hours'] ?? 'N/A' }} horas</strong></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">Tipo de Terreno:</dt>
                                <dd class="col-sm-7">{{ ucwords(str_replace('_', ' ', $inputParams['terrain_type'] ?? 'N/A')) }}</dd>
                                
                                <dt class="col-sm-5">Confianza:</dt>
                                <dd class="col-sm-7">
                                    <div class="progress">
                                        <div class="progress-bar bg-{{ ($meta['prediction_confidence'] ?? 0) > 0.7 ? 'success' : (($meta['prediction_confidence'] ?? 0) > 0.5 ? 'warning' : 'danger') }}" 
                                             style="width: {{ ($meta['prediction_confidence'] ?? 0) * 100 }}%">
                                            {{ round(($meta['prediction_confidence'] ?? 0) * 100, 1) }}%
                                        </div>
                                    </div>
                                </dd>
                                
                                <dt class="col-sm-5">Versión Algoritmo:</dt>
                                <dd class="col-sm-7">{{ $meta['algorithm_version'] ?? 'N/A' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicadores Principales -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $meta['fire_risk_index'] ?? 0 }}</h3>
                    <p>Índice de Riesgo</p>
                    <small>{{ $meta['danger_level'] ?? 'N/A' }}</small>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $meta['total_distance_km'] ?? 0 }} <small>km</small></h3>
                    <p>Distancia Recorrida</p>
                    <small>{{ $meta['propagation_rate'] ?? 'N/A' }}</small>
                </div>
                <div class="icon">
                    <i class="fas fa-route"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $meta['total_area_affected_km2'] ?? 0 }} <small>km²</small></h3>
                    <p>Área Afectada</p>
                    <small>Perímetro: {{ $meta['final_perimeter_km'] ?? 0 }} km</small>
                </div>
                <div class="icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $meta['containment_probability'] ?? 0 }}<small>%</small></h3>
                    <p>Prob. Contención</p>
                    <small>Con recursos adecuados</small>
                </div>
                <div class="icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Condiciones Ambientales -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cloud-sun"></i> Condiciones Ambientales</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-6"><i class="fas fa-thermometer-half text-danger"></i> Temperatura:</dt>
                        <dd class="col-sm-6">{{ $inputParams['temperature'] ?? 'N/A' }}°C</dd>
                        
                        <dt class="col-sm-6"><i class="fas fa-tint text-info"></i> Humedad:</dt>
                        <dd class="col-sm-6">{{ $inputParams['humidity'] ?? 'N/A' }}%</dd>
                        
                        <dt class="col-sm-6"><i class="fas fa-wind text-primary"></i> Velocidad del Viento:</dt>
                        <dd class="col-sm-6">{{ $inputParams['wind_speed'] ?? 'N/A' }} km/h</dd>
                        
                        <dt class="col-sm-6"><i class="fas fa-compass"></i> Dirección del Viento:</dt>
                        <dd class="col-sm-6">
                            {{ $inputParams['wind_direction'] ?? 'N/A' }}° 
                            @php
                                $degrees = $inputParams['wind_direction'] ?? 0;
                                $directions = ['Norte', 'NE', 'Este', 'SE', 'Sur', 'SO', 'Oeste', 'NO'];
                                $index = round($degrees / 45) % 8;
                                $direction = $directions[$index];
                            @endphp
                            ({{ $direction }})
                        </dd>
                        
                        <dt class="col-sm-6">Velocidad de Propagación:</dt>
                        <dd class="col-sm-6"><strong>{{ $meta['spread_speed_kmh'] ?? 'N/A' }} km/h</strong></dd>
                        
                        <dt class="col-sm-6">Factor de Terreno:</dt>
                        <dd class="col-sm-6">{{ $meta['terrain_factor'] ?? 'N/A' }}x</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-map-marker-alt"></i> Posición Final Predicha</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-6">Latitud:</dt>
                        <dd class="col-sm-6"><code>{{ $finalPos['lat'] ?? 'N/A' }}</code></dd>
                        
                        <dt class="col-sm-6">Longitud:</dt>
                        <dd class="col-sm-6"><code>{{ $finalPos['lng'] ?? 'N/A' }}</code></dd>
                        
                        <dt class="col-sm-6">Intensidad Final:</dt>
                        <dd class="col-sm-6">{{ $finalPos['intensity'] ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-6">Radio Máximo:</dt>
                        <dd class="col-sm-6">{{ $meta['max_spread_radius_km'] ?? 'N/A' }} km</dd>
                    </dl>
                    
                    @if(isset($finalPos['lat']) && isset($finalPos['lng']))
                    <div class="mt-3">
                        <a href="https://www.google.com/maps?q={{ $finalPos['lat'] }},{{ $finalPos['lng'] }}" 
                           target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-external-link-alt"></i> Ver en Google Maps
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recursos Necesarios -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users"></i> Recursos Estimados Necesarios</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-warning"><i class="fas fa-user-friends"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Bomberos</span>
                                    <span class="info-box-number">{{ $resources['firefighters'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-danger"><i class="fas fa-truck"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Camiones</span>
                                    <span class="info-box-number">{{ $resources['fire_trucks'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-info"><i class="fas fa-helicopter"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Helicópteros</span>
                                    <span class="info-box-number">{{ $resources['helicopters'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-primary"><i class="fas fa-tint"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Agua (Litros)</span>
                                    <span class="info-box-number">{{ number_format($resources['water_needed_liters'] ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-dollar-sign"></i> <strong>Costo Estimado:</strong> 
                        ${{ number_format($resources['estimated_cost_usd'] ?? 0, 2) }} USD
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recomendaciones -->
    @if(!empty($recommendations))
    <div class="row">
        <div class="col-md-12">
            <div class="card card-{{ $meta['fire_risk_index'] > 70 ? 'danger' : ($meta['fire_risk_index'] > 40 ? 'warning' : 'info') }}">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lightbulb"></i> Recomendaciones de Acción</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @foreach($recommendations as $recommendation)
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> {{ $recommendation }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Trayectoria Hora por Hora -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-route"></i> Trayectoria Predicha (Hora por Hora)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr class="bg-light">
                                    <th>Hora</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
                                    <th>Intensidad</th>
                                    <th>Radio (km)</th>
                                    <th>Área (km²)</th>
                                    <th>Perímetro (km)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prediction->path ?? [] as $point)
                                <tr>
                                    <td><strong>{{ $point['hour'] }}</strong></td>
                                    <td><code>{{ $point['lat'] }}</code></td>
                                    <td><code>{{ $point['lng'] }}</code></td>
                                    <td>
                                        <span class="badge badge-{{ $point['intensity'] > 7 ? 'danger' : ($point['intensity'] > 4 ? 'warning' : 'info') }}">
                                            {{ $point['intensity'] }}
                                        </span>
                                    </td>
                                    <td>{{ $point['spread_radius_km'] }}</td>
                                    <td>{{ $point['affected_area_km2'] }}</td>
                                    <td>{{ $point['perimeter_km'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('predictions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a la Lista
                    </a>
                    <a href="{{ route('predictions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Predicción
                    </a>
                    <button onclick="window.print()" class="btn btn-info">
                        <i class="fas fa-print"></i> Imprimir Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    @media print {
        .btn, .card-tools { display: none; }
    }
</style>
@endsection
