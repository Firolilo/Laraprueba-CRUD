@extends('adminlte::page')

@section('title', 'Predicciones')

@section('content_header')
    <h1><i class="fas fa-chart-line text-primary"></i> Predicciones de Propagación</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Predicciones') }}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('predictions.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                  <i class="fas fa-plus"></i> {{ __('Generar Predicción') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Foco de Incendio</th>
                                        <th>Fecha de Predicción</th>
                                        <th>Horas</th>
                                        <th>Riesgo</th>
                                        <th>Área Afectada</th>
                                        <th>Puntos</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($predictions as $prediction)
                                        @php
                                            $meta = $prediction->meta ?? [];
                                            $riesgo = $meta['fire_risk_index'] ?? 0;
                                            $area = $meta['total_area_affected_km2'] ?? 0;
                                            $horas = $meta['input_parameters']['prediction_hours'] ?? 0;
                                        @endphp
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>
                                                <strong>{{ $prediction->focoIncendio->ubicacion ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $prediction->focoIncendio->fecha?->format('d/m/Y') }}</small>
                                            </td>
                                            <td>{{ $prediction->predicted_at?->format('d/m/Y H:i') ?? 'N/A' }}</td>
                                            <td>{{ $horas }}h</td>
                                            <td>
                                                <span class="badge badge-{{ $riesgo > 70 ? 'danger' : ($riesgo > 40 ? 'warning' : 'info') }}">
                                                    {{ $riesgo }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($area, 2) }} km²</td>
                                            <td>{{ is_array($prediction->path) ? count($prediction->path) : 0 }}</td>
                                            <td>
                                                <form action="{{ route('predictions.destroy', $prediction->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('predictions.show', $prediction->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar?') ? this.closest('form').submit() : false;">
                                                        <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $predictions->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@stop
