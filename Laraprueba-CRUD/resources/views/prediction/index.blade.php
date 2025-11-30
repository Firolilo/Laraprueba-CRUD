@extends('layouts.app')

@section('subtitle', 'Predicciones')
@section('content_header_title', 'Predicciones de Propagación')
@section('content_header_subtitle', 'Listado')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if ($message = Session::get('success'))
                    <x-adminlte-alert theme="success" dismissable>
                        {{ $message }}
                    </x-adminlte-alert>
                @endif

                <x-adminlte-card title="Predicciones" theme="purple" icon="fas fa-chart-line">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Generar Predicción" icon="fas fa-plus" 
                            class="btn-sm" theme="success" href="{{ route('predictions.create') }}"/>
                    </x-slot>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foco de Incendio</th>
                                    <th>Fecha de Predicción</th>
                                    <th>Horas</th>
                                    <th>Riesgo</th>
                                    <th>Área Afectada</th>
                                    <th>Puntos</th>
                                    <th style="width: 180px;">Acciones</th>
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
                                            <div class="btn-group btn-group-sm" role="group">
                                                <x-adminlte-button icon="fas fa-eye" theme="info" 
                                                    href="{{ route('predictions.show', $prediction->id) }}" size="sm" title="Ver"/>
                                                <form action="{{ route('predictions.destroy', $prediction->id) }}" method="POST" style="display: inline;" 
                                                    onsubmit="return confirm('¿Estás seguro de eliminar?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-adminlte-button type="submit" icon="fas fa-trash" 
                                                        theme="danger" size="sm" title="Eliminar"/>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {!! $predictions->withQueryString()->links() !!}
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection
