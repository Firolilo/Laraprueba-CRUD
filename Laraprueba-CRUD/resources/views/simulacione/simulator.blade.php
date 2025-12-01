@extends('adminlte::page')

@section('title', 'Simulador de Incendios')

@section('content_header')
    <h1>Simulador Avanzado de Incendios</h1>
@stop

@section('content')
<div x-data="fireSimulator()" x-init="init()">
    <!-- Controles principales debajo de estadísticas -->
    <div class="card">
        <div class="card-body">
            <!-- Estadísticas -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 x-text="timeElapsed + 'h'"></h3>
                            <p>Tiempo transcurrido</p>
                        </div>
                        <div class="icon"><i class="fas fa-clock"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 x-text="activeFires.length"></h3>
                            <p>Focos activos</p>
                        </div>
                        <div class="icon"><i class="fas fa-fire"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 x-text="requiredVolunteers"></h3>
                            <p>Voluntarios necesarios</p>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box" :class="fireRisk > 70 ? 'bg-danger' : fireRisk > 40 ? 'bg-warning' : 'bg-success'">
                        <div class="inner">
                            <h3 x-text="fireRisk + '%'"></h3>
                            <p>Riesgo de incendio</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-auto mb-2">
                    <button type="button" 
                            class="btn btn-lg btn-success shadow icon-text"
                            :class="simulationActive ? 'btn-danger' : 'btn-success'"
                            @click="toggleSimulation()">
                        <i :class="simulationActive ? 'fas fa-stop-circle' : 'fas fa-play-circle'"></i>
                        <span x-text="simulationActive ? 'Detener Simulación' : 'Iniciar Simulación'"></span>
                    </button>
                </div>

                <div class="col-auto mb-2">
                    <button type="button" class="btn btn-warning btn-lg shadow icon-text" @click="clearFires()">
                        <i class="fas fa-broom"></i>
                        <span>Limpiar Todo</span>
                    </button>
                </div>

                <div class="col-auto mb-2">
                    <button type="button" class="btn btn-info btn-lg shadow icon-text" @click="showHistory = true">
                        <i class="fas fa-history"></i>
                        <span>Ver Historial</span>
                    </button>
                </div>

                <div class="col-auto mb-2">
                    <button type="button" class="btn btn-primary btn-lg shadow icon-text" @click="downloadSimulation()">
                        <i class="fas fa-download"></i>
                        <span>Descargar JSON</span>
                    </button>
                </div>
            </div>

            <style>
            /* Botones compactos, solo icono por defecto */
            .icon-text {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0; /* No espacio entre icono y texto inicialmente */
                transition: all 0.3s ease;
                overflow: hidden;
                padding: 0.5rem 0.6rem; /* Ajusta según tamaño del botón */
            }

            /* Texto oculto inicialmente */
            .icon-text span {
                display: inline-block;
                max-width: 0;
                opacity: 0;
                overflow: hidden;
                white-space: nowrap;
                transition: max-width 0.3s ease, opacity 0.3s ease, margin-left 0.3s ease;
                margin-left: 0;
            }

            /* Mostrar texto al hover */
            .icon-text:hover span {
                max-width: 200px; /* ancho máximo del texto visible */
                opacity: 1;
                margin-left: 8px; /* separación del icono */
            }
            </style>


            <!-- Mapa -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div id="map" style="height: 500px; border-radius: 8px;"></div>
                </div>
            </div>


            <!-- Controles de parámetros -->
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="card-title"><i class="fas fa-sliders-h"></i> Parámetros Ambientales</h3>
                    <div class="card-tools">
                        <button type="button" 
                                class="btn btn-sm btn-danger mr-2" 
                                @click="loadFireHotspots()"
                                :disabled="loadingFires">
                            <i class="fas" :class="loadingFires ? 'fa-spinner fa-spin' : 'fa-fire'"></i>
                            <span x-text="loadingFires ? 'Cargando...' : 'Cargar Focos de Calor'"></span>
                        </button>
                        <button type="button" 
                                class="btn btn-sm btn-primary" 
                                @click="loadCurrentWeather()"
                                :disabled="loadingWeather">
                            <i class="fas" :class="loadingWeather ? 'fa-spinner fa-spin' : 'fa-cloud-sun'"></i>
                            <span x-text="loadingWeather ? 'Cargando...' : 'Cargar Clima Actual'"></span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-thermometer-half text-danger"></i> Temperatura
                                </label>
                                <div class="input-group">
                                    <input type="range" class="custom-range" min="0" max="50" step="0.5"
                                           x-model.number="temperature" :disabled="simulationActive">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-danger text-white font-weight-bold" 
                                              x-text="temperature + '°C'" style="min-width: 70px;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-tint text-info"></i> Humedad
                                </label>
                                <div class="input-group">
                                    <input type="range" class="custom-range" min="0" max="100" step="1"
                                           x-model.number="humidity" :disabled="simulationActive">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-info text-white font-weight-bold" 
                                              x-text="humidity + '%'" style="min-width: 70px;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-wind text-success"></i> Velocidad del Viento
                                </label>
                                <div class="input-group">
                                    <input type="range" class="custom-range" min="0" max="50" step="0.5"
                                           x-model.number="windSpeed" :disabled="simulationActive">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-success text-white font-weight-bold" 
                                              x-text="windSpeed + ' km/h'" style="min-width: 90px;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-compass text-primary"></i> Dirección del Viento
                                </label>
                                <div class="input-group">
                                    <input type="range" class="custom-range" min="0" max="360" step="15"
                                           x-model.number="windDirection" :disabled="simulationActive">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary text-white font-weight-bold" 
                                              x-text="windDirection + '°'" style="min-width: 70px;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-tachometer-alt text-warning"></i> Velocidad de Simulación
                                </label>
                                <div class="input-group">
                                    <input type="range" class="custom-range" min="1" max="10" step="1"
                                           x-model.number="simulationSpeed">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-warning text-dark font-weight-bold" 
                                              x-text="simulationSpeed + 'x'" style="min-width: 70px;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estrategias de mitigación -->
            <div class="row mt-3" x-show="mitigationStrategies.length > 0">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Estrategias de Mitigación Recomendadas:</h5>
                        <ul class="mb-0">
                            <template x-for="strategy in mitigationStrategies" :key="strategy">
                                <li x-text="strategy"></li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de guardar - Solo para administradores -->
    @if(auth()->user()->isAdministrador())
    <div class="modal" :class="{'show d-block': showSaveModal}" tabindex="-1" x-show="showSaveModal" 
         style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Guardar Simulación</h5>
                    <button type="button" class="close" @click="showSaveModal = false">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre de la simulación (opcional)</label>
                        <input type="text" class="form-control" x-model="simulationName" 
                               placeholder="Ej: Simulación Zona Norte">
                    </div>
                    <div class="form-group">
                        <label>Administrador <span class="text-danger">*</span></label>
                        <select class="form-control" x-model.number="adminId" required>
                            <option value="">Seleccionar administrador...</option>
                            @foreach($administradores as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->user->name }} - {{ $admin->departamento }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Campo requerido</small>
                    </div>
                    <p class="text-muted">
                        Duración: <strong x-text="timeElapsed + 'h'"></strong><br>
                        Focos activos: <strong x-text="activeFires.length"></strong><br>
                        Voluntarios: <strong x-text="requiredVolunteers"></strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showSaveModal = false">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="saveSimulation()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de historial -->
    <div class="modal" :class="{'show d-block': showHistory}" tabindex="-1" x-show="showHistory" 
         style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Historial de Simulaciones</h5>
                    <button type="button" class="close" @click="showHistory = false">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Duración</th>
                                <th>Focos</th>
                                <th>Voluntarios</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="sim in historyData" :key="sim.id">
                                <tr>
                                    <td x-text="sim.fecha"></td>
                                    <td x-text="sim.nombre"></td>
                                    <td x-text="sim.duracion"></td>
                                    <td x-text="sim.focos"></td>
                                    <td x-text="sim.voluntarios"></td>
                                    <td>
                                        <button class="btn btn-sm btn-success" @click="repeatSimulation(sim)">
                                            <i class="fas fa-redo"></i> Repetir
                                        </button>
                                        <button class="btn btn-sm btn-danger" @click="deleteSimulation(sim.id)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showHistory = false">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .leaflet-container {
        cursor: crosshair;
    }
    .modal.show {
        display: block !important;
    }
    .biomasa-tooltip {
        background-color: rgba(40, 167, 69, 0.9) !important;
        color: white !important;
        border: none !important;
        border-radius: 4px !important;
        padding: 5px 10px !important;
        font-weight: bold !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3) !important;
    }
    
    /* Estilos para marcadores de fuego */
    .custom-fire-marker {
        background: transparent !important;
        border: none !important;
        animation: fire-pulse 2s ease-in-out infinite;
    }
    
    .custom-fire-marker:hover {
        animation: none;
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }
    
    @keyframes fire-pulse {
        0%, 100% {
            filter: drop-shadow(0 0 3px rgba(220, 38, 38, 0.6));
        }
        50% {
            filter: drop-shadow(0 0 8px rgba(220, 38, 38, 0.9));
        }
    }
    
    .leaflet-popup-content-wrapper {
        border-radius: 8px !important;
        padding: 0 !important;
        overflow: hidden;
    }
    
    .leaflet-popup-content {
        margin: 15px 20px !important;
    }
</style>
@stop

@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
// Helper functions para notificaciones
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function showSuccess(message) {
    Toast.fire({
        icon: 'success',
        title: message
    });
}

function showError(message) {
    Toast.fire({
        icon: 'error',
        title: message
    });
}

function showInfo(message) {
    Toast.fire({
        icon: 'info',
        title: message
    });
}

function showWarning(message) {
    Toast.fire({
        icon: 'warning',
        title: message
    });
}

function showConfirm(title, text, confirmText = 'Sí, eliminar') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: confirmText,
        cancelButtonText: 'Cancelar'
    });
}

function showWeatherData(temp, humidity, wind) {
    Swal.fire({
        title: '✅ Datos Climáticos Cargados',
        html: `
            <div style="text-align: left; font-size: 1.1em;">
                <p><i class="fas fa-thermometer-half" style="color: #ff6b6b;"></i> <strong>Temperatura:</strong> ${temp}°C</p>
                <p><i class="fas fa-tint" style="color: #4ecdc4;"></i> <strong>Humedad:</strong> ${humidity}%</p>
                <p><i class="fas fa-wind" style="color: #95e1d3;"></i> <strong>Viento:</strong> ${wind} km/h</p>
            </div>
        `,
        icon: 'success',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#28a745'
    });
}

function fireSimulator() {
    return {
        // State
        map: null,
        fires: [],
        initialFires: [],
        activeFires: [],
        allFiresHistory: [], // Historial completo de todos los focos
        simulationActive: false,
        timeElapsed: 0,
        requiredVolunteers: 0,
        mitigationStrategies: [],
        fireRisk: 0,
        showSaveModal: false,
        showHistory: false,
        simulationName: '',
        adminId: null,
        historyData: [],
        interval: null,
        biomasas: @json($biomasas ?? []),
        biomasaLayers: [],
        loadingWeather: false,
        loadingFires: false,
        
        // Parameters
        temperature: 25,
        humidity: 50,
        windSpeed: 10,
        windDirection: 0,
        simulationSpeed: 1,
        
        // Config
        MAX_ACTIVE_FIRES: 500,
        MERGE_DISTANCE: 0.02,
        
        init() {
            console.log('Biomasas cargadas:', this.biomasas.length);
            this.initMap();
            this.loadHistory();
            
            // Calculate initial fire risk
            this.calculateFireRisk();
            
            // Watch parameters for fire risk calculation
            this.$watch('temperature', () => this.calculateFireRisk());
            this.$watch('humidity', () => this.calculateFireRisk());
            this.$watch('windSpeed', () => this.calculateFireRisk());
        },
        
        initMap() {
            this.map = L.map('map').setView([-17.8, -61.5], 9);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(this.map);
            
            // Dibujar biomasas en el mapa
            this.drawBiomasas();
            
            this.map.on('click', (e) => {
                if (!this.simulationActive && this.fires.length < this.MAX_ACTIVE_FIRES * 2) {
                    this.addFire(e.latlng.lat, e.latlng.lng);
                }
            });
        },
        
        drawBiomasas() {
            this.biomasas.forEach((biomasa) => {
                if (!biomasa.coordenadas || biomasa.coordenadas.length < 3) return;
                
                const tipo = biomasa.tipo_biomasa?.tipo_biomasa || 'Desconocido';
                const color = biomasa.tipo_biomasa?.color || '#808080';
                const modifier = biomasa.tipo_biomasa?.modificador_intensidad || 1.0;
                
                const latLngs = biomasa.coordenadas.map(coord => {
                    if (Array.isArray(coord)) {
                        return [parseFloat(coord[0]), parseFloat(coord[1])];
                    }
                    return [parseFloat(coord.lat || coord[0]), parseFloat(coord.lng || coord[1])];
                });
                
                const polygon = L.polygon(latLngs, {
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.15,
                    weight: 2,
                    opacity: 0.5,
                    dashArray: '5, 5',
                    interactive: false
                }).addTo(this.map);
                
                this.biomasaLayers.push({
                    polygon: polygon,
                    coords: latLngs,
                    tipo: tipo,
                    modifier: parseFloat(modifier),
                    id: biomasa.id
                });
            });
        },
        
        // Función para detectar si un punto está dentro de una biomasa
        getBiomasaModifier(lat, lng) {
            for (let biomasa of this.biomasaLayers) {
                if (this.isPointInPolygon(lat, lng, biomasa.coords)) {
                    return {
                        inside: true,
                        tipo: biomasa.tipo,
                        modifier: biomasa.modifier,
                        id: biomasa.id
                    };
                }
            }
            return { inside: false, modifier: 1.0 };
        },
        
        // Ray Casting algorithm para detectar punto en polígono
        isPointInPolygon(lat, lng, polygon) {
            const numVertices = polygon.length;
            let inside = false;

            for (let i = 0, j = numVertices - 1; i < numVertices; j = i++) {
                const xi = polygon[i][0];
                const yi = polygon[i][1];
                const xj = polygon[j][0];
                const yj = polygon[j][1];

                const intersect = ((yi > lng) !== (yj > lng))
                    && (lat < (xj - xi) * (lng - yi) / (yj - yi) + xi);

                if (intersect) inside = !inside;
            }

            return inside;
        },
        
        addFire(lat, lng, initialIntensity = 1) {
            const fire = {
                id: Date.now() + Math.random(),
                position: [lat, lng],
                intensity: initialIntensity,
                spread: 0,
                direction: this.windDirection,
                active: true,
                history: [[lat, lng]],
                marker: null,
                circle: null,
                lastExpansionTime: this.timeElapsed // Tiempo del último paso de expansión
            };
            
            // Add visual marker
            fire.circle = L.circle([lat, lng], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 100
            }).addTo(this.map);
            
            this.fires.push(fire);
            
            // Solo agregar a initialFires si es un foco inicial (no propagado)
            if (this.timeElapsed === 0 || !this.simulationActive) {
                this.initialFires.push(fire);
            }
            
            this.updateActiveFires();
        },
        
        toggleSimulation() {
            if (this.fires.length === 0 && !this.simulationActive) {
                showInfo('Añade focos haciendo clic en el mapa');
                return;
            }
            
            this.simulationActive = !this.simulationActive;
            
            if (this.simulationActive) {
                this.timeElapsed = 0;
                this.startSimulation();
            } else {
                this.stopSimulation();
                // Notificar finalización si hubo simulación
                if (this.timeElapsed > 0) {
                    this.showSimulationComplete();
                }
            }
        },
        
        async showSimulationComplete() {
            const activeFires = this.fires.filter(f => f.active).length;
            const totalFires = this.fires.length;
            const affectedArea = (totalFires * 0.01).toFixed(2); // Estimación simple
            
            const isAdmin = {{ auth()->user()->isAdministrador() ? 'true' : 'false' }};
            
            const result = await Swal.fire({
                icon: 'info',
                title: 'Simulación Completada',
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <h5 class="mb-3"><i class="fas fa-chart-line"></i> Resultados:</h5>
                        <table class="table table-sm">
                            <tr>
                                <td><i class="fas fa-clock text-primary"></i> Tiempo transcurrido:</td>
                                <td><strong>${this.timeElapsed}h</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-fire text-danger"></i> Focos activos:</td>
                                <td><strong>${activeFires} / ${totalFires}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-map-marked-alt text-success"></i> Área afectada:</td>
                                <td><strong>~${affectedArea} km²</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-users text-info"></i> Voluntarios sugeridos:</td>
                                <td><strong>${this.requiredVolunteers}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-exclamation-triangle text-warning"></i> Nivel de riesgo:</td>
                                <td><strong>${this.fireRisk.toFixed(0)}%</strong></td>
                            </tr>
                        </table>
                        <hr>
                        <p class="text-muted mb-2"><i class="fas fa-info-circle"></i> ¿Qué deseas hacer?</p>
                    </div>
                `,
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: isAdmin ? '<i class="fas fa-save"></i> Guardar' : '<i class="fas fa-share-alt"></i> Compartir',
                denyButtonText: '<i class="fas fa-redo"></i> Repetir',
                cancelButtonText: '<i class="fas fa-times"></i> Nueva',
                confirmButtonColor: '#28a745',
                denyButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                allowOutsideClick: false
            });
            
            if (result.isConfirmed) {
                // Guardar (admin) o Compartir (usuario regular)
                if (isAdmin) {
                    this.showSaveModal = true;
                } else {
                    this.shareSimulation();
                }
            } else if (result.isDenied) {
                // Repetir la misma simulación
                this.repeatCurrentSimulation();
            } else {
                // Nueva simulación (cancelar)
                this.clearFires();
            }
        },
        
        repeatCurrentSimulation() {
            const currentParams = {
                temperature: this.temperature,
                humidity: this.humidity,
                windSpeed: this.windSpeed,
                windDirection: this.windDirection,
                simulationSpeed: this.simulationSpeed
            };
            const currentInitialFires = [...this.initialFires];
            
            this.clearFires();
            
            // Restaurar parámetros
            this.temperature = currentParams.temperature;
            this.humidity = currentParams.humidity;
            this.windSpeed = currentParams.windSpeed;
            this.windDirection = currentParams.windDirection;
            this.simulationSpeed = currentParams.simulationSpeed;
            
            // Restaurar focos iniciales
            currentInitialFires.forEach(fire => {
                this.addFire(fire.position[0], fire.position[1], fire.intensity);
            });
            
            showSuccess('Simulación reiniciada con los mismos parámetros');
        },
        
        async shareSimulation() {
            const shareData = {
                timeElapsed: this.timeElapsed,
                activeFires: this.fires.filter(f => f.active).length,
                totalFires: this.fires.length,
                volunteersNeeded: this.requiredVolunteers,
                fireRisk: this.fireRisk.toFixed(0),
                parameters: {
                    temperature: this.temperature,
                    humidity: this.humidity,
                    windSpeed: this.windSpeed,
                    windDirection: this.windDirection
                }
            };
            
            const shareText = `📊 Resultados de Simulación SIPII:\n` +
                `⏱️ Tiempo: ${shareData.timeElapsed}h\n` +
                `🔥 Focos: ${shareData.activeFires}/${shareData.totalFires}\n` +
                `👥 Voluntarios: ${shareData.volunteersNeeded}\n` +
                `⚠️ Riesgo: ${shareData.fireRisk}%\n` +
                `🌡️ Condiciones: ${shareData.parameters.temperature}°C, ` +
                `${shareData.parameters.humidity}% humedad, ` +
                `viento ${shareData.parameters.windSpeed} km/h`;
            
            // Intentar usar Web Share API si está disponible
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Simulación SIPII',
                        text: shareText
                    });
                    showSuccess('Simulación compartida exitosamente');
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        this.copyToClipboard(shareText);
                    }
                }
            } else {
                this.copyToClipboard(shareText);
            }
        },
        
        copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showSuccess('Resultados copiados al portapapeles');
            }).catch(() => {
                showError('No se pudo copiar al portapapeles');
            });
        },
        
        startSimulation() {
            this.interval = setInterval(() => {
                this.timeElapsed++;
                this.propagateFires();
                this.updateActiveFires();
                this.calculateVolunteers();
                this.updateMitigationStrategies();
                
                // Auto stop at 20h o cuando no haya focos activos
                const activeFiresCount = this.fires.filter(f => f.active).length;
                if (this.timeElapsed >= 20 || activeFiresCount === 0) {
                    this.toggleSimulation();
                }
            }, 1000 / this.simulationSpeed);
        },
        
        stopSimulation() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        },
        
        propagateFires() {
            const firesToRemove = [];
            const newFires = [];
            
            this.fires.forEach(fire => {
                if (!fire.active) return;
                
                // Verificar si el foco ha pasado más de 5 segundos sin expandirse
                if (this.timeElapsed - fire.lastExpansionTime >= 5) {
                    fire.active = false;
                    if (fire.circle) this.map.removeLayer(fire.circle);
                    firesToRemove.push(fire.id);
                    return;
                }
                
                // Probabilidad de expansión basada en el riesgo de incendio
                const expansionProbability = this.fireRisk / 100; // 0 a 1
                const randomValue = Math.random();
                
                // Si NO se expande, aumentar contador de tiempo sin expansión
                if (randomValue > expansionProbability) {
                    // No se expande este paso, pero sigue activo
                    return;
                }
                
                // SE EXPANDE: calcular dirección y crear nuevo foco
                fire.lastExpansionTime = this.timeElapsed; // Actualizar tiempo de última expansión
                
                // Detectar si el fuego está en una biomasa
                const biomasaData = this.getBiomasaModifier(fire.position[0], fire.position[1]);
                const biomasaModifier = biomasaData.modifier;
                
                const spreadRate = (this.fireRisk / 100) * (this.windSpeed / 20) * 
                                 (this.temperature / 30) * (1 - (this.humidity / 150)) * biomasaModifier;
                const spreadDistance = 0.01 * spreadRate * this.simulationSpeed;
                
                if (spreadDistance < 0.001) {
                    fire.active = false;
                    if (fire.circle) this.map.removeLayer(fire.circle);
                    firesToRemove.push(fire.id);
                    return;
                }
                
                // Dirección de propagación con variación aleatoria
                const finalDirection = fire.direction + (Math.random() - 0.5) * 60; // ±30°
                const angleRad = (finalDirection * Math.PI) / 180;
                
                const lat = fire.position[0] + Math.cos(angleRad) * spreadDistance;
                const lng = fire.position[1] + Math.sin(angleRad) * spreadDistance;
                
                // Aplicar modificador de biomasa a la intensidad
                const intensityDecay = biomasaModifier > 1.0 ? 0.98 : 0.95; // Biomasa densa = declive más lento
                const newIntensity = fire.intensity * intensityDecay * biomasaModifier;
                
                // Verificar si hay espacio para más focos
                if (this.fires.length + newFires.length < this.MAX_ACTIVE_FIRES) {
                    const newFire = {
                        id: `${fire.id}-${this.timeElapsed}`,
                        position: [lat, lng],
                        intensity: newIntensity,
                        spread: fire.spread + spreadDistance,
                        direction: finalDirection,
                        active: newIntensity > 0.2,
                        history: [...fire.history, [lat, lng]].slice(-10),
                        circle: null,
                        lastExpansionTime: this.timeElapsed
                    };
                    
                    if (newFire.active) {
                        // Verificar fusión con focos cercanos
                        let merged = false;
                        for (let existingFire of [...this.fires, ...newFires]) {
                            if (existingFire.id === fire.id) continue;
                            const dist = Math.sqrt(
                                Math.pow(existingFire.position[0] - lat, 2) + 
                                Math.pow(existingFire.position[1] - lng, 2)
                            );
                            if (dist < this.MERGE_DISTANCE) {
                                existingFire.intensity = Math.min(2, existingFire.intensity + newFire.intensity * 0.3);
                                existingFire.lastExpansionTime = this.timeElapsed;
                                merged = true;
                                break;
                            }
                        }
                        
                        if (!merged) {
                            // Detectar biomasa para el nuevo fuego
                            const newBiomasaData = this.getBiomasaModifier(lat, lng);
                            
                            newFire.circle = L.circle([lat, lng], {
                                color: this.getFireColor(newFire.intensity, newBiomasaData),
                                fillColor: this.getFireColor(newFire.intensity, newBiomasaData),
                                fillOpacity: 0.6,
                                radius: 80 + newFire.spread * 800
                            }).addTo(this.map);
                            
                            // Agregar tooltip si está en biomasa
                            if (newBiomasaData.inside) {
                                newFire.circle.bindTooltip(
                                    `<strong>Intensidad: ${newFire.intensity.toFixed(2)}</strong><br>` +
                                    `<small>Biomasa: ${newBiomasaData.tipo}</small><br>` +
                                    `<small>Modificador: ${newBiomasaData.modifier}x</small>`,
                                    { sticky: true }
                                );
                            }
                            
                            newFires.push(newFire);
                            
                            // Guardar en historial completo con información de biomasa
                            this.allFiresHistory.push({
                                fire_id: newFire.id.toString(),
                                time_step: this.timeElapsed,
                                lat: lat,
                                lng: lng,
                                intensity: newFire.intensity,
                                spread: newFire.spread,
                                active: true,
                                biomasa: newBiomasaData.inside ? {
                                    tipo: newBiomasaData.tipo,
                                    modifier: newBiomasaData.modifier,
                                    id: newBiomasaData.id
                                } : null
                            });
                        }
                    }
                }
            });
            
            // Agregar nuevos focos
            this.fires = [...this.fires, ...newFires];
            
            // Mantener solo focos activos y que no hayan pasado 5 segundos sin expandirse
            this.fires = this.fires.filter(f => {
                const shouldKeep = f.active && (this.timeElapsed - f.lastExpansionTime < 5);
                if (!shouldKeep && f.circle) {
                    this.map.removeLayer(f.circle);
                }
                return shouldKeep;
            });
        },
        
        updateActiveFires() {
            this.activeFires = this.fires.filter(f => f.active);
        },
        
        calculateFireRisk() {
            const tempFactor = Math.min(this.temperature / 40, 1);
            const humFactor = 1 - (this.humidity / 100);
            const windFactor = Math.min(this.windSpeed / 30, 1);
            this.fireRisk = Math.min(Math.round((tempFactor * 0.4 + humFactor * 0.3 + windFactor * 0.3) * 100), 100);
        },
        
        calculateVolunteers() {
            let volunteers = 0;
            this.activeFires.forEach(fire => {
                const area = Math.PI * Math.pow(fire.spread * 100, 2) / 100;
                volunteers += 5 + (fire.intensity * 2) + (area * 0.1);
            });
            this.requiredVolunteers = Math.round(volunteers);
        },
        
        updateMitigationStrategies() {
            const strategies = [];
            
            if (this.activeFires.length === 0) {
                strategies.push("No hay incendios activos. Estado de vigilancia normal.");
            } else {
                if (this.activeFires.length > 5) {
                    strategies.push("🔴 Activación de protocolo de emergencia mayor");
                    strategies.push("🚒 Despliegue de bomberos profesionales");
                } else {
                    strategies.push("🟡 Activación de protocolo de emergencia básico");
                }
                
                if (this.windSpeed > 30) strategies.push("⚠️ Precaución: Vientos fuertes");
                if (this.humidity < 30) strategies.push("💧 Humectación de áreas circundantes");
                strategies.push(`👥 Se requieren aproximadamente ${this.requiredVolunteers} voluntarios`);
            }
            
            this.mitigationStrategies = strategies;
        },
        
        clearFires() {
            this.fires.forEach(fire => {
                if (fire.circle) this.map.removeLayer(fire.circle);
            });
            this.fires = [];
            this.initialFires = [];
            this.activeFires = [];
            this.allFiresHistory = [];
            this.simulationActive = false;
            this.timeElapsed = 0;
            this.stopSimulation();
        },
        
        getFireColor(intensity, biomasaData = null) {
            const heat = Math.min(255, Math.floor(intensity * 51));
            
            // Si está en biomasa, añadir un tinte según el modificador
            if (biomasaData && biomasaData.inside) {
                if (biomasaData.modifier > 1.0) {
                    // Biomasa que acelera (más rojo)
                    return `rgb(255, ${Math.max(0, 255 - heat - 30)}, 0)`;
                } else if (biomasaData.modifier < 1.0) {
                    // Biomasa que frena (más naranja/amarillo)
                    return `rgb(255, ${Math.min(255, 255 - heat + 30)}, 30)`;
                }
            }
            
            return `rgb(255, ${255 - heat}, 0)`;
        },
        
        async saveSimulation() {
            // Validar que se haya seleccionado un administrador
            if (!this.adminId) {
                showWarning('Por favor selecciona un administrador antes de guardar');
                return;
            }
            
            // Agregar focos iniciales al historial
            const initialHistory = this.initialFires.map(f => ({
                fire_id: f.id.toString(),
                time_step: 0,
                lat: f.position[0],
                lng: f.position[1],
                intensity: f.intensity,
                spread: 0,
                active: true
            }));
            
            const data = {
                nombre: this.simulationName || null,
                admin_id: this.adminId,
                duracion: this.timeElapsed,
                focos_activos: this.activeFires.length,
                num_voluntarios_enviados: this.requiredVolunteers,
                estado: 'completada',
                temperature: this.temperature,
                humidity: this.humidity,
                wind_speed: this.windSpeed,
                wind_direction: this.windDirection,
                simulation_speed: this.simulationSpeed,
                fire_risk: this.fireRisk,
                map_center_lat: this.map.getCenter().lat,
                map_center_lng: this.map.getCenter().lng,
                initial_fires: this.initialFires.map(f => ({
                    lat: f.position[0],
                    lng: f.position[1],
                    intensity: f.intensity
                })),
                mitigation_strategies: this.mitigationStrategies,
                auto_stopped: this.timeElapsed >= 20,
                fire_history: [...initialHistory, ...this.allFiresHistory]
            };
            
            try {
                const response = await fetch('{{ route('simulaciones.save') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });
                
                // Verificar si la respuesta es JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const text = await response.text();
                    console.error('Server returned non-JSON response:', text);
                    showError('Error del servidor. Por favor revisa la consola para más detalles.');
                    return;
                }
                
                const result = await response.json();
                
                if (response.status === 422) {
                    console.error('Validation errors:', result);
                    showError('Error de validación: ' + JSON.stringify(result.errors || result.message));
                    return;
                }
                
                if (result.success) {
                    showSuccess('Simulación guardada exitosamente');
                    this.showSaveModal = false;
                    this.simulationName = '';
                    this.adminId = null;
                    this.loadHistory();
                    this.clearFires();
                } else {
                    showError('Error al guardar la simulación: ' + (result.message || 'Error desconocido'));
                    console.error('Error details:', result);
                }
            } catch (error) {
                console.error('Exception:', error);
                showError('Error al guardar la simulación: ' + error.message);
            }
        },
        
        async loadHistory() {
            try {
                const response = await fetch('{{ route('simulaciones.history') }}');
                this.historyData = await response.json();
            } catch (error) {
                console.error(error);
            }
        },
        
        async loadCurrentWeather() {
            this.loadingWeather = true;
            try {
                // Coordenadas de San José de Chiquitos
                const latitude = -17.8857;
                const longitude = -60.7556;
                
                // Llamar a la API de Open-Meteo
                const url = `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,relative_humidity_2m,wind_speed_10m,wind_direction_10m&timezone=America/La_Paz`;
                
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error('Error al obtener datos del clima');
                }
                
                const data = await response.json();
                
                // Actualizar parámetros con datos actuales
                this.temperature = Math.round(data.current.temperature_2m);
                this.humidity = Math.round(data.current.relative_humidity_2m);
                this.windSpeed = Math.round(data.current.wind_speed_10m);
                this.windDirection = Math.round(data.current.wind_direction_10m);
                
                // Recalcular riesgo con nuevos datos
                this.calculateFireRisk();
                
                // Notificar éxito
                showWeatherData(this.temperature, this.humidity, this.windSpeed);
                
            } catch (error) {
                console.error('Error loading weather:', error);
                showError('Error al cargar datos climáticos. Intenta nuevamente.');
            } finally {
                this.loadingWeather = false;
            }
        },
        
        async loadFireHotspots() {
            this.loadingFires = true;
            try {
                // Llamar a la API de focos de calor
                const response = await fetch('/api/fires?cluster=true&radius=20&days=2');
                
                if (!response.ok) {
                    throw new Error('Error al obtener datos de focos de calor');
                }
                
                const data = await response.json();
                const fires = data.data || [];
                
                if (fires.length === 0) {
                    showWarning('No se encontraron focos de calor en los últimos 2 días.');
                    return;
                }
                
                // Agregar focos a la simulación
                let addedCount = 0;
                fires.forEach(fire => {
                    // Calcular intensidad basada en FRP y tamaño del cluster
                    const clusterSize = fire.cluster_size || 1;
                    const frp = fire.frp || 5;
                    // Intensidad entre 1-5 basada en FRP normalizado
                    const intensity = Math.min(5, Math.max(1, Math.round(frp / 50)));
                    
                    // Agregar el foco a la simulación
                    this.addFire(fire.lat, fire.lng, intensity);
                    addedCount++;
                    
                    // Si es un cluster grande, agregar focos adicionales cercanos
                    if (clusterSize > 3) {
                        const extraFires = Math.min(3, Math.floor(clusterSize / 5));
                        for (let i = 0; i < extraFires; i++) {
                            // Offset aleatorio pequeño (±0.005 grados ≈ 500m)
                            const offsetLat = (Math.random() - 0.5) * 0.01;
                            const offsetLng = (Math.random() - 0.5) * 0.01;
                            this.addFire(
                                fire.lat + offsetLat, 
                                fire.lng + offsetLng, 
                                Math.max(1, intensity - 1)
                            );
                            addedCount++;
                        }
                    }
                });
                
                // Notificar éxito
                const totalFires = fires.reduce((sum, f) => sum + (f.cluster_size || 1), 0);
                const clusters = fires.filter(f => f.is_cluster).length;
                
                Swal.fire({
                    icon: 'success',
                    title: 'Focos de Calor Cargados',
                    html: `
                        <div style="text-align: left; padding: 10px;">
                            <p><i class="fas fa-fire text-danger"></i> <strong>${totalFires}</strong> focos detectados</p>
                            <p><i class="fas fa-layer-group text-primary"></i> <strong>${clusters}</strong> puntos calientes</p>
                            <p><i class="fas fa-plus-circle text-success"></i> <strong>${addedCount}</strong> focos agregados a la simulación</p>
                            <p class="mt-2 text-muted" style="font-size: 0.9em;">
                                <i class="fas fa-info-circle"></i> Los focos están listos para simular
                            </p>
                        </div>
                    `,
                    timer: 5000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                
            } catch (error) {
                console.error('Error loading fire hotspots:', error);
                showError('Error al cargar focos de calor. Intenta nuevamente.');
            } finally {
                this.loadingFires = false;
            }
        },
        
        repeatSimulation(sim) {
            this.clearFires();
            this.temperature = sim.parameters.temperature;
            this.humidity = sim.parameters.humidity;
            this.windSpeed = sim.parameters.windSpeed;
            this.windDirection = sim.parameters.windDirection;
            this.simulationSpeed = sim.parameters.simulationSpeed;
            
            sim.initialFires.forEach(fire => {
                this.addFire(fire.lat, fire.lng);
            });
            
            this.showHistory = false;
            this.toggleSimulation();
        },
        
        async deleteSimulation(id) {
            const result = await showConfirm(
                '¿Eliminar simulación?',
                'Esta acción no se puede deshacer'
            );
            
            if (!result.isConfirmed) return;
            
            try {
                const response = await fetch(`/simulaciones/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const result = await response.json();
                if (result.success) {
                    this.loadHistory();
                }
            } catch (error) {
                console.error(error);
            }
        },
        
        downloadSimulation() {
            const data = {
                timestamp: new Date().toISOString(),
                location: "San José de Chiquitos",
                duration: this.timeElapsed,
                volunteers: this.requiredVolunteers,
                parameters: {
                    temperature: this.temperature,
                    humidity: this.humidity,
                    windSpeed: this.windSpeed,
                    windDirection: this.windDirection,
                    simulationSpeed: this.simulationSpeed
                },
                initialFires: this.initialFires.map(f => ({
                    lat: f.position[0],
                    lng: f.position[1],
                    intensity: f.intensity
                })),
                fireRisk: this.fireRisk
            };
            
            const blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `simulacion-${Date.now()}.json`;
            a.click();
        }
    }
}
</script>
@stop
