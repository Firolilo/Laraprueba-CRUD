<div class="row padding-1 p-1">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="fecha">Fecha</label>
            <input type="datetime-local" name="fecha" id="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', optional($focosIncendio->fecha)->format('Y-m-d\TH:i')) }}">
            @error('fecha')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="ubicacion">Ubicación</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion', $focosIncendio->ubicacion) }}">
            @error('ubicacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="intensidad">Intensidad</label>
            <input type="number" step="0.01" name="intensidad" id="intensidad" class="form-control @error('intensidad') is-invalid @enderror" value="{{ old('intensidad', $focosIncendio->intensidad) }}">
            @error('intensidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="coordenadas">Coordenadas [lat, lng]</label>
            <input type="text" name="coordenadas" id="coordenadas" class="form-control @error('coordenadas') is-invalid @enderror" value="{{ old('coordenadas', $focosIncendio->coordenadas ? json_encode($focosIncendio->coordenadas) : '') }}" placeholder='[-17.8, -61.5]' readonly>
            @error('coordenadas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="form-text text-muted">Haga clic en el mapa para seleccionar las coordenadas</small>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group mb-3">
            <label>Seleccionar ubicación en el mapa</label>
            <div id="map" style="height: 400px; border-radius: 8px; border: 1px solid #ddd;"></div>
            <small class="form-text text-muted">Haga clic en el mapa para marcar la ubicación del foco de incendio</small>
        </div>
    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        <a href="{{ route('focos-incendios.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-container {
        cursor: crosshair;
    }
</style>
@endpush

@push('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    (function() {
        let focoMap;
        let focoMarker;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Coordenadas por defecto (San José de Chiquitos)
            const defaultLat = -17.8;
            const defaultLng = -61.5;
            
            // Obtener coordenadas existentes si están disponibles
            let initialCoords = [defaultLat, defaultLng];
            const coordsInput = document.getElementById('coordenadas');
            if (coordsInput.value) {
                try {
                    const coords = JSON.parse(coordsInput.value);
                    if (Array.isArray(coords) && coords.length === 2) {
                        initialCoords = coords;
                    }
                } catch (e) {
                    console.log('No se pudieron parsear las coordenadas existentes');
                }
            }
            
            // Inicializar mapa
            focoMap = L.map('map').setView(initialCoords, 12);
            
            // Agregar capa de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(focoMap);
            
            // Si hay coordenadas existentes, agregar marcador
            if (coordsInput.value) {
                focoMarker = L.marker(initialCoords, {
                    draggable: true
                }).addTo(focoMap);
                
                focoMarker.on('dragend', function(e) {
                    const position = focoMarker.getLatLng();
                    updateCoordinates(position.lat, position.lng);
                });
            }
            
            // Agregar evento de clic en el mapa
            focoMap.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                
                // Eliminar marcador anterior si existe
                if (focoMarker) {
                    focoMap.removeLayer(focoMarker);
                }
                
                // Agregar nuevo marcador
                focoMarker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(focoMap);
                
                // Actualizar coordenadas
                updateCoordinates(lat, lng);
                
                // Evento para cuando se arrastra el marcador
                focoMarker.on('dragend', function(e) {
                    const position = focoMarker.getLatLng();
                    updateCoordinates(position.lat, position.lng);
                });
            });
        });
        
        function updateCoordinates(lat, lng) {
            const coordsInput = document.getElementById('coordenadas');
            const roundedLat = Math.round(lat * 1000000) / 1000000;
            const roundedLng = Math.round(lng * 1000000) / 1000000;
            coordsInput.value = JSON.stringify([roundedLat, roundedLng]);
        }
    })();
</script>
@endpush