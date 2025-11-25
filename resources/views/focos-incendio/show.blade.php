@extends('adminlte::page')

@section('template_title')
    {{ $focosIncendio->ubicacion ?? __('Ver') . " Foco de Incendio" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Foco de Incendio</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('focos-incendios.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4">Fecha:</dt>
                                    <dd class="col-sm-8">{{ optional($focosIncendio->fecha)->format('d/m/Y H:i') }}</dd>

                                    <dt class="col-sm-4">Ubicación:</dt>
                                    <dd class="col-sm-8">{{ $focosIncendio->ubicacion }}</dd>

                                    <dt class="col-sm-4">Intensidad:</dt>
                                    <dd class="col-sm-8">
                                        <span class="badge badge-{{ $focosIncendio->intensidad > 7 ? 'danger' : ($focosIncendio->intensidad > 4 ? 'warning' : 'info') }}">
                                            {{ $focosIncendio->intensidad }}
                                        </span>
                                    </dd>

                                    <dt class="col-sm-4">Coordenadas:</dt>
                                    <dd class="col-sm-8">
                                        @if($focosIncendio->coordenadas)
                                            Latitud: {{ $focosIncendio->coordenadas[0] }}<br>
                                            Longitud: {{ $focosIncendio->coordenadas[1] }}
                                        @else
                                            <span class="text-muted">No disponibles</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                            
                            <div class="col-md-6">
                                @if($focosIncendio->coordenadas)
                                <div class="form-group">
                                    <label>Ubicación en el mapa</label>
                                    <div id="map" style="height: 300px; border-radius: 8px; border: 1px solid #ddd;"></div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    @if($focosIncendio->coordenadas)
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endif
@endsection

@section('js')
    @if($focosIncendio->coordenadas)
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const coords = @json($focosIncendio->coordenadas);
            
            if (coords && coords.length === 2) {
                const map = L.map('map').setView(coords, 13);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                
                // Agregar marcador del foco
                const marker = L.marker(coords).addTo(map);
                marker.bindPopup('<b>{{ $focosIncendio->ubicacion }}</b><br>Intensidad: {{ $focosIncendio->intensidad }}').openPopup();
            }
        });
    </script>
    @endif
@endsection
