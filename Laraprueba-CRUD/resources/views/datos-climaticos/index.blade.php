@extends('layouts.app')

@section('subtitle', 'Datos Climáticos')
@section('content_header_title', 'Datos Climáticos Históricos -')
@section('content_header_subtitle')
    {{ $ubicacion }} - Última Semana
@endsection

@section('content_body')
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Período:</strong> {{ $fechaInicio->format('d/m/Y') }} - {{ $fechaFin->format('d/m/Y') }}
                <span class="float-right">
                    <i class="fas fa-map-marker-alt"></i> {{ $ubicacion }}
                </span>
            </div>
        </div>
    </div>

    {{-- Resumen en cards --}}
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ number_format(max($datosGraficas['temperatura']), 1) }}°C" 
                                  text="Temperatura Máxima" 
                                  icon="fas fa-temperature-high" 
                                  theme="danger"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ number_format(max($datosGraficas['humedad']), 0) }}%" 
                                  text="Humedad Máxima" 
                                  icon="fas fa-tint" 
                                  theme="info"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ number_format(array_sum($datosGraficas['precipitacion']), 1) }} mm" 
                                  text="Precipitación Total" 
                                  icon="fas fa-cloud-rain" 
                                  theme="primary"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ number_format(max($datosGraficas['viento']), 1) }} km/h" 
                                  text="Viento Máximo" 
                                  icon="fas fa-wind" 
                                  theme="success"/>
        </div>
    </div>

    {{-- Gráfica de Temperatura --}}
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Temperatura Horaria" theme="danger" icon="fas fa-temperature-high">
                <canvas id="temperaturaChart" height="80"></canvas>
            </x-adminlte-card>
        </div>
    </div>

    {{-- Gráficas de Humedad y Precipitación --}}
    <div class="row">
        <div class="col-lg-6">
            <x-adminlte-card title="Humedad Relativa" theme="info" icon="fas fa-tint">
                <canvas id="humedadChart" height="120"></canvas>
            </x-adminlte-card>
        </div>
        <div class="col-lg-6">
            <x-adminlte-card title="Precipitación Acumulada" theme="primary" icon="fas fa-cloud-rain">
                <canvas id="precipitacionChart" height="120"></canvas>
            </x-adminlte-card>
        </div>
    </div>

    {{-- Gráfica de Viento --}}
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Velocidad del Viento" theme="success" icon="fas fa-wind">
                <canvas id="vientoChart" height="80"></canvas>
            </x-adminlte-card>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Datos del backend
    const datosGraficas = @json($datosGraficas);
    
    // Formatear labels para mostrar solo fecha/hora legible
    const labels = datosGraficas.labels.map(label => {
        const fecha = new Date(label);
        const dia = fecha.getDate().toString().padStart(2, '0');
        const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
        const hora = fecha.getHours().toString().padStart(2, '0');
        return `${dia}/${mes} ${hora}:00`;
    });
    
    // Configuración común para todas las gráficas
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            x: {
                ticks: {
                    maxRotation: 45,
                    minRotation: 45,
                    maxTicksLimit: 24 // Mostrar máximo 24 etiquetas
                }
            }
        }
    };
    
    // Gráfica de Temperatura
    new Chart(document.getElementById('temperaturaChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Temperatura (°C)',
                data: datosGraficas.temperatura,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Temperatura (°C)'
                    }
                }
            }
        }
    });
    
    // Gráfica de Humedad
    new Chart(document.getElementById('humedadChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Humedad (%)',
                data: datosGraficas.humedad,
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Humedad (%)'
                    }
                }
            }
        }
    });
    
    // Gráfica de Precipitación
    new Chart(document.getElementById('precipitacionChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Precipitación (mm)',
                data: datosGraficas.precipitacion,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Precipitación (mm)'
                    }
                }
            }
        }
    });
    
    // Gráfica de Viento
    new Chart(document.getElementById('vientoChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Velocidad del Viento (km/h)',
                data: datosGraficas.viento,
                borderColor: 'rgb(75, 192, 75)',
                backgroundColor: 'rgba(75, 192, 75, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Velocidad (km/h)'
                    }
                }
            }
        }
    });
</script>
@endpush
