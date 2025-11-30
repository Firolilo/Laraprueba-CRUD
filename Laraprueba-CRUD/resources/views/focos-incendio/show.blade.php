@extends('layouts.app')

@section('subtitle', 'Ver Foco de Incendio')
@section('content_header_title', 'Focos de Incendio')
@section('content_header_subtitle', 'Detalle')

@section('content_body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Información del Foco de Incendio: {{ $focosIncendio->ubicacion }}" theme="info" icon="fas fa-fire">
                    <x-slot name="toolsSlot">
                        <x-adminlte-button label="Volver" icon="fas fa-arrow-left" 
                            class="btn-sm" theme="secondary" href="{{ route('focos-incendios.index') }}"/>
                        <x-adminlte-button label="Editar" icon="fas fa-edit" 
                            class="btn-sm" theme="warning" href="{{ route('focos-incendios.edit', $focosIncendio->id) }}"/>
                    </x-slot>

                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-callout theme="danger" title="Fecha">
                                {{ optional($focosIncendio->fecha)->format('d/m/Y H:i') }}
                            </x-adminlte-callout>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-callout theme="primary" title="Ubicación">
                                {{ $focosIncendio->ubicacion }}
                            </x-adminlte-callout>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-callout theme="warning" title="Intensidad">
                                <span class="badge badge-{{ $focosIncendio->intensidad > 7 ? 'danger' : ($focosIncendio->intensidad > 4 ? 'warning' : 'info') }}" style="font-size: 18px;">
                                    {{ $focosIncendio->intensidad }}
                                </span>
                            </x-adminlte-callout>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-callout theme="info" title="Coordenadas">
                                @if($focosIncendio->coordenadas)
                                    Latitud: {{ $focosIncendio->coordenadas[0] }}<br>
                                    Longitud: {{ $focosIncendio->coordenadas[1] }}
                                @else
                                    <span class="text-muted">No disponibles</span>
                                @endif
                            </x-adminlte-callout>
                        </div>
                        
                        @if($focosIncendio->coordenadas)
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ubicación en el mapa</label>
                                <div id="map" style="height: 300px; border-radius: 8px; border: 1px solid #ddd;"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
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
