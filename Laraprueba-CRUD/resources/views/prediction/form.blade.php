<div class="row">
    <div class="col-md-12">
        <x-adminlte-alert theme="info" icon="fas fa-info-circle">
            <strong>Sistema de Predicción de Propagación de Incendios</strong>
            <p class="mb-0">Seleccione un foco de incendio existente y configure los parámetros ambientales para generar una predicción de su propagación.</p>
        </x-adminlte-alert>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="foco_incendio_id" class="form-label">
                <i class="fas fa-fire text-danger"></i> Foco de Incendio <span class="text-danger">*</span>
            </label>
            <select name="foco_incendio_id" id="foco_incendio_id" class="form-control @error('foco_incendio_id') is-invalid @enderror" required>
                <option value="">Seleccione un foco...</option>
                @foreach($focosIncendios as $foco)
                    <option value="{{ $foco->id }}" 
                            data-lat="{{ $foco->coordenadas[0] ?? '' }}" 
                            data-lng="{{ $foco->coordenadas[1] ?? '' }}"
                            data-intensity="{{ $foco->intensidad ?? 5 }}"
                            {{ old('foco_incendio_id', $prediction?->foco_incendio_id) == $foco->id ? 'selected' : '' }}>
                        {{ $foco->ubicacion }} - {{ $foco->fecha?->format('d/m/Y H:i') }} (Intensidad: {{ $foco->intensidad }})
                    </option>
                @endforeach
            </select>
            {!! $errors->first('foco_incendio_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            <small class="form-text text-muted">Solo se muestran focos con coordenadas definidas</small>
        </div>

        <div id="foco-details" class="alert alert-secondary d-none mb-3">
            <strong>Detalles del Foco:</strong><br>
            <small>
                Coordenadas: <span id="foco-coords">-</span><br>
                Intensidad inicial: <span id="foco-intensity">-</span>
            </small>
        </div>
    </div>

    <div class="col-md-6">
        <x-adminlte-input name="prediction_hours" label="Horas de Predicción" type="number"
            value="{{ old('prediction_hours', 24) }}" 
            min="1" max="72" enable-old-support>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-clock text-primary"></i>
                </div>
            </x-slot>
            <x-slot name="bottomSlot">
                Entre 1 y 72 horas <span class="text-danger">*</span>
            </x-slot>
        </x-adminlte-input>

        <div class="form-group mb-3">
            <label for="terrain_type" class="form-label">
                <i class="fas fa-mountain text-success"></i> Tipo de Terreno <span class="text-danger">*</span>
            </label>
            <select name="terrain_type" id="terrain_type" class="form-control @error('terrain_type') is-invalid @enderror" required>
                <option value="bosque_denso" {{ old('terrain_type') == 'bosque_denso' ? 'selected' : '' }}>🌲 Bosque Denso (alta propagación)</option>
                <option value="bosque_normal" {{ old('terrain_type') == 'bosque_normal' ? 'selected' : '' }}>🌳 Bosque Normal</option>
                <option value="pastizal" {{ old('terrain_type', 'pastizal') == 'pastizal' ? 'selected' : '' }}>🌾 Pastizal (propagación media)</option>
                <option value="matorral" {{ old('terrain_type') == 'matorral' ? 'selected' : '' }}>🌿 Matorral</option>
                <option value="rocoso" {{ old('terrain_type') == 'rocoso' ? 'selected' : '' }}>🪨 Rocoso (baja propagación)</option>
            </select>
            {!! $errors->first('terrain_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-12">
        <h5 class="mt-3 mb-3"><i class="fas fa-cloud-sun text-warning"></i> Condiciones Ambientales</h5>
    </div>

    <div class="col-md-3">
        <x-adminlte-input name="temperature" label="Temperatura (°C)" type="number"
            value="{{ old('temperature', 25) }}" 
            min="0" max="60" step="0.1" enable-old-support>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-thermometer-half text-danger"></i>
                </div>
            </x-slot>
            <x-slot name="bottomSlot">
                <span class="text-danger">*</span>
            </x-slot>
        </x-adminlte-input>
    </div>

    <div class="col-md-3">
        <x-adminlte-input name="humidity" label="Humedad (%)" type="number"
            value="{{ old('humidity', 50) }}" 
            min="0" max="100" step="0.1" enable-old-support>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-tint text-info"></i>
                </div>
            </x-slot>
            <x-slot name="bottomSlot">
                <span class="text-danger">*</span>
            </x-slot>
        </x-adminlte-input>
    </div>

    <div class="col-md-3">
        <x-adminlte-input name="wind_speed" label="Velocidad del Viento (km/h)" type="number"
            value="{{ old('wind_speed', 10) }}" 
            min="0" max="200" step="0.1" enable-old-support>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-wind text-primary"></i>
                </div>
            </x-slot>
            <x-slot name="bottomSlot">
                <span class="text-danger">*</span>
            </x-slot>
        </x-adminlte-input>
    </div>

    <div class="col-md-3">
        <x-adminlte-input name="wind_direction" label="Dirección del Viento (°)" type="number"
            value="{{ old('wind_direction', 0) }}" 
            min="0" max="360" enable-old-support>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-compass text-secondary"></i>
                </div>
            </x-slot>
            <x-slot name="bottomSlot">
                0° = Norte, 90° = Este, 180° = Sur, 270° = Oeste <span class="text-danger">*</span>
            </x-slot>
        </x-adminlte-input>
    </div>

    <div class="col-md-12 mt-3">
        <x-adminlte-button type="submit" label="Generar Predicción" theme="primary" icon="fas fa-chart-line" class="btn-lg"/>
        <x-adminlte-button label="Cancelar" theme="secondary" icon="fas fa-times" class="btn-lg"
            href="{{ route('predictions.index') }}"/>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const focoSelect = document.getElementById('foco_incendio_id');
    const focoDetails = document.getElementById('foco-details');
    const focoCoords = document.getElementById('foco-coords');
    const focoIntensity = document.getElementById('foco-intensity');

    focoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const lat = selectedOption.getAttribute('data-lat');
            const lng = selectedOption.getAttribute('data-lng');
            const intensity = selectedOption.getAttribute('data-intensity');

            focoCoords.textContent = `${lat}, ${lng}`;
            focoIntensity.textContent = intensity;
            focoDetails.classList.remove('d-none');
        } else {
            focoDetails.classList.add('d-none');
        }
    });

    // Trigger change if there's a selected value
    if (focoSelect.value) {
        focoSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
