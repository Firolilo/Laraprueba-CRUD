@extends('adminlte::page')

@section('template_title')
    Mapa de Biomasas
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-map-marked-alt"></i> Mapa de Zonas de Biomasa</h1>
        <a href="{{ route('biomasas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Agregar Biomasa
        </a>
    </div>
@stop

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check-circle"></i> {{ $message }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0" style="height: 75vh;">
            <div id="map" style="width: 100%; height: 100%;"></div>
        </div>
        
        <!-- Legend Card -->
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-info-circle"></i> Leyenda de Tipos de Biomasa</h5>
                    <div id="legend" class="d-flex flex-wrap gap-3"></div>
                </div>
                <div class="col-md-6 text-right">
                    <small class="text-muted">
                        <i class="fas fa-mouse-pointer"></i> Haga clic en un polígono para ver detalles
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Panel for Selected Polygon -->
    <div id="infoPanel" class="card" style="display: none;">
        <div class="card-header bg-info">
            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información de la Zona</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tipo de Biomasa:</strong> <span id="info-tipo"></span></p>
                    <p><strong>Área:</strong> <span id="info-area"></span> m²</p>
                    <p><strong>Densidad:</strong> <span id="info-densidad"></span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha de Reporte:</strong> <span id="info-fecha"></span></p>
                    <p><strong>Ubicación:</strong> <span id="info-ubicacion"></span></p>
                    <p><strong>Descripción:</strong> <span id="info-descripcion"></span></p>
                </div>
            </div>
            <div class="text-right mt-2">
                <a id="info-edit" href="#" class="btn btn-success btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <button id="info-delete" onclick="deleteBiomasa()" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
                <button onclick="closeInfoPanel()" class="btn btn-secondary btn-sm">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Form (hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .legend-item {
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
            margin-bottom: 10px;
        }
        .legend-color {
            width: 30px;
            height: 20px;
            border: 2px solid #333;
            border-radius: 3px;
            margin-right: 8px;
        }
        #infoPanel {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 500px;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }
    </style>
@stop

@section('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize the map centered on a default location
        const map = L.map('map').setView([-17.8, -61.5], 8); // Chiquitanía, Bolivia

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Store biomasas data
        const biomasasData = @json($biomasas);
        let currentBiomasaId = null;
        
        console.log('Biomasas cargadas:', biomasasData.length);
        
        // Object to store tipo counts and create legend
        const tipoColors = {};
        const polygonLayers = {};

        // Process each biomasa
        biomasasData.forEach((biomasa, index) => {
            console.log(`Procesando biomasa ${biomasa.id}:`, biomasa);
            
            if (!biomasa.coordenadas || biomasa.coordenadas.length === 0) {
                console.warn(`Biomasa ${biomasa.id} no tiene coordenadas`);
                return;
            }

            const tipo = biomasa.tipo_biomasa?.tipo_biomasa || 'Desconocido';
            const color = biomasa.tipo_biomasa?.color || '#808080';
            
            // Track tipos for legend
            if (!tipoColors[tipo]) {
                tipoColors[tipo] = color;
            }

            // Convert coordinates to Leaflet format [[lat, lng], ...]
            // Las coordenadas se guardan como arrays: [[lat, lng], [lat, lng], ...]
            const latLngs = biomasa.coordenadas.map(coord => {
                // Si coord es un array [lat, lng], usarlo directamente
                if (Array.isArray(coord)) {
                    return [parseFloat(coord[0]), parseFloat(coord[1])];
                }
                // Si coord es un objeto {lat, lng}, convertirlo
                return [parseFloat(coord.lat || coord[0]), parseFloat(coord.lng || coord[1])];
            });

            console.log(`Coordenadas procesadas para biomasa ${biomasa.id}:`, latLngs);

            // Create polygon
            const polygon = L.polygon(latLngs, {
                color: color,
                fillColor: color,
                fillOpacity: 0.5,
                weight: 3,
                opacity: 1
            }).addTo(map);

            // Add click event to show info
            polygon.on('click', function() {
                showBiomasaInfo(biomasa);
            });

            // Add tooltip on hover
            polygon.bindTooltip(`
                <strong>${tipo}</strong><br>
                Área: ${(biomasa.area_m2 / 1000000).toFixed(2)} km²
            `, {
                sticky: true
            });

            // Store polygon reference
            polygonLayers[biomasa.id] = polygon;
        });

        console.log('Total de polígonos creados:', Object.keys(polygonLayers).length);

        // Auto-fit map to show all polygons
        if (Object.keys(polygonLayers).length > 0) {
            const group = L.featureGroup(Object.values(polygonLayers));
            map.fitBounds(group.getBounds(), { padding: [50, 50] });
        } else {
            console.warn('No se encontraron polígonos para mostrar');
        }

        // Build legend
        const legendDiv = document.getElementById('legend');
        Object.entries(tipoColors).forEach(([tipo, color]) => {
            const item = document.createElement('div');
            item.className = 'legend-item';
            item.innerHTML = `
                <div class="legend-color" style="background-color: ${color};"></div>
                <span><strong>${tipo}</strong></span>
            `;
            legendDiv.appendChild(item);
        });

        // Show biomasa information in panel
        function showBiomasaInfo(biomasa) {
            currentBiomasaId = biomasa.id;
            document.getElementById('info-tipo').textContent = biomasa.tipo_biomasa?.tipo_biomasa || 'N/A';
            document.getElementById('info-area').textContent = (biomasa.area_m2 / 1000000).toFixed(2) + ' km²';
            document.getElementById('info-densidad').textContent = biomasa.densidad || 'N/A';
            document.getElementById('info-fecha').textContent = biomasa.fecha_reporte || 'N/A';
            document.getElementById('info-ubicacion').textContent = biomasa.ubicacion || 'N/A';
            document.getElementById('info-descripcion').textContent = biomasa.descripcion || 'Sin descripción';
            document.getElementById('info-edit').href = `/biomasas/${biomasa.id}/edit`;
            
            document.getElementById('infoPanel').style.display = 'block';
        }

        function closeInfoPanel() {
            currentBiomasaId = null;
            document.getElementById('infoPanel').style.display = 'none';
        }

        function deleteBiomasa() {
            if (!currentBiomasaId) {
                alert('No hay biomasa seleccionada');
                return;
            }

            if (!confirm('¿Está seguro de que desea eliminar esta zona de biomasa? Esta acción no se puede deshacer.')) {
                return;
            }

            const form = document.getElementById('deleteForm');
            form.action = `/biomasas/${currentBiomasaId}`;
            form.submit();
        }
    </script>
@stop
