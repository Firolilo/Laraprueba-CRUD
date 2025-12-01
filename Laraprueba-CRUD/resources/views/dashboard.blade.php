@extends('layouts.app')

@section('subtitle', 'Dashboard')
@section('content_header_title', 'Panel Principal')

@section('content_body')
    <div class="row">
        {{-- Mapa principal con focos y biomasas --}}
        <div class="col-lg-8">
            <x-adminlte-card title="Mapa de Monitoreo" theme="light" icon="fas fa-map-marked-alt">
                <div id="map"></div>
                <div class="mt-2 text-sm text-muted">
                    <i class="fas fa-fire text-danger"></i> Puntos de calor (FIRMS) &nbsp;&nbsp;
                    <i class="fas fa-leaf text-success"></i> Áreas de biomasa
                </div>
            </x-adminlte-card>
        </div>

        {{-- Sidebar con biomasas listadas --}}
        <div class="col-lg-4">
            <x-adminlte-card title="Áreas de Biomasa ({{ $biomasasCount }})" theme="success" icon="fas fa-leaf">
                {{-- Filtros por tipo de biomasa --}}
                <div class="mb-3">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-success dropdown-toggle btn-block" type="button" 
                                id="dropdownFiltros" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-filter"></i> Filtrar por tipo de biomasa
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="dropdownFiltros" style="padding: 10px;">
                            @php
                                $tiposBiomasa = \App\Models\TipoBiomasa::select('id', 'tipo_biomasa', 'color')->get();
                            @endphp
                            @foreach($tiposBiomasa as $tipo)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input filtro-biomasa" 
                                           id="filtro-{{ $tipo->id }}" 
                                           value="{{ $tipo->id }}" 
                                           data-tipo="{{ $tipo->tipo_biomasa }}"
                                           checked>
                                    <label class="custom-control-label" for="filtro-{{ $tipo->id }}">
                                        <i class="fas fa-circle" style="color: {{ $tipo->color }}; font-size: 10px;"></i>
                                        {{ $tipo->tipo_biomasa }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="dropdown-divider"></div>
                            <button class="btn btn-sm btn-outline-secondary btn-block" onclick="seleccionarTodos()">
                                <i class="fas fa-check-double"></i> Seleccionar Todos
                            </button>
                            <button class="btn btn-sm btn-outline-secondary btn-block" onclick="deseleccionarTodos()">
                                <i class="fas fa-times"></i> Deseleccionar Todos
                            </button>
                        </div>
                    </div>
                </div>
                
                <div id="biomasas-list" style="max-height: 350px; overflow-y: auto;">
                    <p class="text-muted text-center">
                        <i class="fas fa-spinner fa-spin"></i> Cargando biomasas...
                    </p>
                </div>
            </x-adminlte-card>
        </div>
    </div>

    {{-- Cards de clima y estadísticas --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body weather-card">
                    <div class="label">Temperatura Actual</div>
                    <div class="value" id="temperature">
                        @if(isset($weather['data']['current_weather']['temperature']))
                            {{ $weather['data']['current_weather']['temperature'] }}°C
                        @else
                            --°C
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body weather-card">
                    <div class="label">Humedad</div>
                    <div class="value" id="humidity">
                        @if(isset($weather['data']['hourly']['relative_humidity_2m'][0]))
                            {{ $weather['data']['hourly']['relative_humidity_2m'][0] }}%
                        @else
                            --%
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body weather-card">
                    <div class="label">Precipitación</div>
                    <div class="value" id="precipitation">
                        @if(isset($weather['data']['hourly']['precipitation'][0]))
                            {{ $weather['data']['hourly']['precipitation'][0] }} mm
                        @else
                            0 mm
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body weather-card">
                    <div class="label">Puntos de calor</div>
                    <div class="value text-danger">{{ $firesCount }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body weather-card">
                    <div class="label">Áreas de biomasa</div>
                    <div class="value text-success">{{ $biomasasCount }}</div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
<style>
    #map {
        height: 460px;
        width: 100%;
        border-radius: 4px;
    }
    .weather-card {
        text-align: center;
        padding: 15px;
    }
    .weather-card .label {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 8px;
    }
    .weather-card .value {
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
    }
</style>
@endpush

@push('js')
<script>
    // Esperar a que todo esté cargado (Leaflet incluido)
    function initDashboard() {
        // Verificar que Leaflet esté disponible
        if (typeof L === 'undefined') {
            console.warn('Leaflet aún no está cargado, reintentando en 100ms...');
            setTimeout(initDashboard, 100);
            return;
        }
        
        console.log('✓ Leaflet cargado correctamente');
        console.log('✓ Inicializando dashboard...');
        
        // Initialize map centered on San José de Chiquitos, Bolivia
        const map = L.map('map').setView([-17.8857, -60.7556], 12);
        console.log('Mapa inicializado:', map);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

    // Fire icon
    const fireIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    // Load fire hotspots
    fetch('/api/fires')
        .then(res => res.json())
        .then(result => {
            if (result.ok && result.data && result.data.length > 0) {
                result.data.forEach(fire => {
                    const marker = L.marker([fire.lat, fire.lng], { icon: fireIcon }).addTo(map);
                    marker.bindPopup(`
                        <strong><i class="fas fa-fire text-danger"></i> Foco de Calor</strong><br>
                        <strong>Fecha:</strong> ${fire.date}<br>
                        <strong>Confianza:</strong> ${fire.confidence || 'N/A'}<br>
                        <strong>Lat:</strong> ${fire.lat.toFixed(4)}<br>
                        <strong>Lng:</strong> ${fire.lng.toFixed(4)}
                    `);
                });
            }
        })
        .catch(err => console.error('Error loading fires:', err));

    // Variables globales para filtrado
    let allBiomasas = null;
    let biomasaLayer = null;

    // Load biomasas
    console.log('Intentando cargar biomasas desde /dashboard/biomasas...');
    fetch('/dashboard/biomasas', {
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(res => {
            console.log('Respuesta recibida:', res.status, res.statusText);
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(geojson => {
            console.log('Biomasas cargadas:', geojson);
            console.log('Features encontrados:', geojson.features ? geojson.features.length : 0);
            
            // Guardar todas las biomasas
            allBiomasas = geojson;
            
            // Renderizar inicialmente todas las biomasas
            renderBiomasas(geojson);
            
            // Agregar event listeners a los filtros
            document.querySelectorAll('.filtro-biomasa').forEach(checkbox => {
                checkbox.addEventListener('change', filtrarBiomasas);
            });
        })
        .catch(err => {
            console.error('Error loading biomasas:', err);
            const listContainer = document.getElementById('biomasas-list');
            listContainer.innerHTML = `<p class="text-danger text-center">
                <i class="fas fa-exclamation-triangle"></i> Error al cargar biomasas<br>
                <small>${err.message}</small>
            </p>`;
        });
    
    // Función para renderizar biomasas en el mapa
    function renderBiomasas(geojson) {
        // Remover capa anterior si existe
        if (biomasaLayer) {
            map.removeLayer(biomasaLayer);
        }
        
        biomasaLayer = L.geoJSON(geojson, {
            style: function(feature) {
                const color = feature.properties.color || '#28a745';
                return {
                    color: color,
                    weight: 2,
                    fillColor: color,
                    fillOpacity: 0.3
                };
            },
            onEachFeature: (feature, layer) => {
                const props = feature.properties;
                layer.bindPopup(`
                    <strong><i class="fas fa-leaf text-success"></i> Área de Biomasa</strong><br>
                    <strong>Ubicación:</strong> ${props.ubicacion}<br>
                    <strong>Área:</strong> ${props.area}<br>
                    <strong>Densidad:</strong> ${props.densidad}<br>
                    <strong>Tipo:</strong> ${props.tipo}<br>
                    <strong>Fecha:</strong> ${props.fecha}
                    ${props.descripcion ? `<br><strong>Descripción:</strong> ${props.descripcion}` : ''}
                `);
            }
        }).addTo(map);

        // Build sidebar list
        const listContainer = document.getElementById('biomasas-list');
        if (geojson.features.length === 0) {
            listContainer.innerHTML = '<p class="text-muted text-center">No hay biomasas con los filtros seleccionados</p>';
        } else {
            let html = '<ul class="list-unstyled">';
            geojson.features.forEach((feature, index) => {
                const props = feature.properties;
                const color = props.color || '#28a745';
                const densidadClass = props.densidad === 'alta' ? 'success' : 
                                     props.densidad === 'media' ? 'warning' : 'info';
                html += `
                    <li class="mb-2 border-bottom pb-2">
                        <strong style="color: ${color};"><i class="fas fa-leaf"></i> ${props.tipo}</strong>
                        <br><small class="text-muted">${props.fecha}</small>
                        <br><span class="badge badge-${densidadClass}">Densidad: ${props.densidad}</span>
                        <br><small>Área: ${props.area}</small>
                    </li>
                `;
            });
            html += '</ul>';
            listContainer.innerHTML = html;
        }

        // Fit map to show all features if any exist
        if (geojson.features.length > 0) {
            map.fitBounds(biomasaLayer.getBounds(), { padding: [20, 20] });
        }
    }
    
    // Función para filtrar biomasas según checkboxes
    function filtrarBiomasas() {
        if (!allBiomasas) return;
        
        // Obtener tipos seleccionados
        const tiposSeleccionados = Array.from(document.querySelectorAll('.filtro-biomasa:checked'))
            .map(cb => cb.getAttribute('data-tipo'));
        
        console.log('Tipos seleccionados:', tiposSeleccionados);
        
        // Filtrar features
        const filteredGeoJSON = {
            type: 'FeatureCollection',
            features: allBiomasas.features.filter(feature => 
                tiposSeleccionados.includes(feature.properties.tipo)
            )
        };
        
        console.log('Biomasas filtradas:', filteredGeoJSON.features.length);
        
        // Re-renderizar
        renderBiomasas(filteredGeoJSON);
    }
    
    // Función para seleccionar todos los filtros
    window.seleccionarTodos = function() {
        document.querySelectorAll('.filtro-biomasa').forEach(cb => {
            cb.checked = true;
        });
        filtrarBiomasas();
    };
    
    // Función para deseleccionar todos los filtros
    window.deseleccionarTodos = function() {
        document.querySelectorAll('.filtro-biomasa').forEach(cb => {
            cb.checked = false;
        });
        filtrarBiomasas();
    };
    } // Fin de initDashboard
    
    // Iniciar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDashboard);
    } else {
        // DOM ya está listo, iniciar inmediatamente
        initDashboard();
    }
</script>
@endpush
