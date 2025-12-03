<div class="row">
    <div class="col-md-12">
        <?php if (isset($component)) { $__componentOriginal9d0273d6550ddf39dc9a547c96729fed = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9d0273d6550ddf39dc9a547c96729fed = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Alert::resolve(['theme' => 'info','icon' => 'fas fa-info-circle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Alert::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <strong>Sistema de Predicción de Propagación de Incendios</strong>
            <p class="mb-0">Seleccione un foco de incendio en el mapa y configure los parámetros ambientales para generar una predicción de su propagación.</p>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d0273d6550ddf39dc9a547c96729fed)): ?>
<?php $attributes = $__attributesOriginal9d0273d6550ddf39dc9a547c96729fed; ?>
<?php unset($__attributesOriginal9d0273d6550ddf39dc9a547c96729fed); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d0273d6550ddf39dc9a547c96729fed)): ?>
<?php $component = $__componentOriginal9d0273d6550ddf39dc9a547c96729fed; ?>
<?php unset($__componentOriginal9d0273d6550ddf39dc9a547c96729fed); ?>
<?php endif; ?>
    </div>

    <!-- Mapa para seleccionar foco -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-map-marked-alt"></i> Seleccionar Foco de Incendio (FIRMS)</h5>
            </div>
            <div class="card-body p-0">
                <div id="prediction-map" style="height: 400px; width: 100%;"></div>
            </div>
            <div class="card-footer text-muted">
                <i class="fas fa-fire text-danger"></i> Haga clic en un foco de calor para seleccionarlo
            </div>
        </div>
    </div>

    <!-- Panel de foco seleccionado -->
    <div class="col-md-4">
        <div class="card" id="selected-fire-card" style="display: none;">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-check-circle"></i> Foco Seleccionado</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong><i class="fas fa-map-marker-alt text-danger"></i> Coordenadas:</strong>
                    <p class="mb-1" id="selected-coords">-</p>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-bolt text-warning"></i> Potencia (FRP):</strong>
                    <p class="mb-1" id="selected-frp">-</p>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-fire text-danger"></i> Intensidad:</strong>
                    <p class="mb-1" id="selected-intensity">-</p>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-calendar"></i> Fecha:</strong>
                    <p class="mb-1" id="selected-date">-</p>
                </div>
                <div class="mb-0">
                    <strong><i class="fas fa-shield-alt"></i> Confianza:</strong>
                    <p class="mb-0" id="selected-confidence">-</p>
                </div>
            </div>
        </div>

        <div class="card" id="no-fire-card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-hand-pointer"></i> Sin Selección</h5>
            </div>
            <div class="card-body text-center text-muted">
                <i class="fas fa-mouse-pointer fa-3x mb-3"></i>
                <p>Haga clic en un foco de calor en el mapa para seleccionarlo</p>
            </div>
        </div>

        <!-- Campos ocultos para el formulario -->
        <input type="hidden" name="fire_lat" id="fire_lat" value="<?php echo e(old('fire_lat', request('fire_lat'))); ?>">
        <input type="hidden" name="fire_lng" id="fire_lng" value="<?php echo e(old('fire_lng', request('fire_lng'))); ?>">
        <input type="hidden" name="fire_intensity" id="fire_intensity" value="<?php echo e(old('fire_intensity', request('fire_intensity', 3))); ?>">
        <input type="hidden" name="fire_frp" id="fire_frp" value="<?php echo e(old('fire_frp', request('fire_frp'))); ?>">
    </div>

    <div class="col-md-6 mt-3">
        <?php if (isset($component)) { $__componentOriginale5d826ae10df3aa87f8449f474c11664 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5d826ae10df3aa87f8449f474c11664 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Input::resolve(['name' => 'prediction_hours','label' => 'Horas de Predicción','enableOldSupport' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','value' => ''.e(old('prediction_hours', 24)).'','min' => '1','max' => '72']); ?>
             <?php $__env->slot('prependSlot', null, []); ?> 
                <div class="input-group-text">
                    <i class="fas fa-clock text-primary"></i>
                </div>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('bottomSlot', null, []); ?> 
                Entre 1 y 72 horas <span class="text-danger">*</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $attributes = $__attributesOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__attributesOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $component = $__componentOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__componentOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
    </div>

    <div class="col-md-6 mt-3">
        <div class="form-group mb-3">
            <label for="terrain_type" class="form-label">
                <i class="fas fa-mountain text-success"></i> Tipo de Terreno <span class="text-danger">*</span>
            </label>
            <select name="terrain_type" id="terrain_type" class="form-control <?php $__errorArgs = ['terrain_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <option value="bosque_denso" <?php echo e(old('terrain_type') == 'bosque_denso' ? 'selected' : ''); ?>>🌲 Bosque Denso (alta propagación)</option>
                <option value="bosque_normal" <?php echo e(old('terrain_type') == 'bosque_normal' ? 'selected' : ''); ?>>🌳 Bosque Normal</option>
                <option value="pastizal" <?php echo e(old('terrain_type', 'pastizal') == 'pastizal' ? 'selected' : ''); ?>>🌾 Pastizal (propagación media)</option>
                <option value="matorral" <?php echo e(old('terrain_type') == 'matorral' ? 'selected' : ''); ?>>🌿 Matorral</option>
                <option value="rocoso" <?php echo e(old('terrain_type') == 'rocoso' ? 'selected' : ''); ?>>🪨 Rocoso (baja propagación)</option>
            </select>
            <?php echo $errors->first('terrain_type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>'); ?>

        </div>
    </div>

    <div class="col-md-12">
        <h5 class="mt-3 mb-3">
            <i class="fas fa-cloud-sun text-warning"></i> Condiciones Ambientales
            <button type="button" id="loadWeatherBtn" class="btn btn-sm btn-info float-right">
                <i class="fas fa-cloud-download-alt"></i> Cargar Clima Actual (Open-Meteo)
            </button>
        </h5>
    </div>

    <div class="col-md-3">
        <?php if (isset($component)) { $__componentOriginale5d826ae10df3aa87f8449f474c11664 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5d826ae10df3aa87f8449f474c11664 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Input::resolve(['name' => 'temperature','label' => 'Temperatura (°C)','enableOldSupport' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','value' => ''.e(old('temperature', 25)).'','min' => '0','max' => '60','step' => '0.1']); ?>
             <?php $__env->slot('prependSlot', null, []); ?> 
                <div class="input-group-text">
                    <i class="fas fa-thermometer-half text-danger"></i>
                </div>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('bottomSlot', null, []); ?> 
                <span class="text-danger">*</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $attributes = $__attributesOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__attributesOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $component = $__componentOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__componentOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
    </div>

    <div class="col-md-3">
        <?php if (isset($component)) { $__componentOriginale5d826ae10df3aa87f8449f474c11664 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5d826ae10df3aa87f8449f474c11664 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Input::resolve(['name' => 'humidity','label' => 'Humedad (%)','enableOldSupport' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','value' => ''.e(old('humidity', 50)).'','min' => '0','max' => '100','step' => '0.1']); ?>
             <?php $__env->slot('prependSlot', null, []); ?> 
                <div class="input-group-text">
                    <i class="fas fa-tint text-info"></i>
                </div>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('bottomSlot', null, []); ?> 
                <span class="text-danger">*</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $attributes = $__attributesOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__attributesOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $component = $__componentOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__componentOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
    </div>

    <div class="col-md-3">
        <?php if (isset($component)) { $__componentOriginale5d826ae10df3aa87f8449f474c11664 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5d826ae10df3aa87f8449f474c11664 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Input::resolve(['name' => 'wind_speed','label' => 'Velocidad del Viento (km/h)','enableOldSupport' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','value' => ''.e(old('wind_speed', 10)).'','min' => '0','max' => '200','step' => '0.1']); ?>
             <?php $__env->slot('prependSlot', null, []); ?> 
                <div class="input-group-text">
                    <i class="fas fa-wind text-primary"></i>
                </div>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('bottomSlot', null, []); ?> 
                <span class="text-danger">*</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $attributes = $__attributesOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__attributesOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $component = $__componentOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__componentOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
    </div>

    <div class="col-md-3">
        <?php if (isset($component)) { $__componentOriginale5d826ae10df3aa87f8449f474c11664 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5d826ae10df3aa87f8449f474c11664 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Input::resolve(['name' => 'wind_direction','label' => 'Dirección del Viento (°)','enableOldSupport' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','value' => ''.e(old('wind_direction', 0)).'','min' => '0','max' => '360']); ?>
             <?php $__env->slot('prependSlot', null, []); ?> 
                <div class="input-group-text">
                    <i class="fas fa-compass text-secondary"></i>
                </div>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('bottomSlot', null, []); ?> 
                0° = Norte, 90° = Este, 180° = Sur, 270° = Oeste <span class="text-danger">*</span>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $attributes = $__attributesOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__attributesOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale5d826ae10df3aa87f8449f474c11664)): ?>
<?php $component = $__componentOriginale5d826ae10df3aa87f8449f474c11664; ?>
<?php unset($__componentOriginale5d826ae10df3aa87f8449f474c11664); ?>
<?php endif; ?>
    </div>

    <div class="col-md-12 mt-3">
        <?php if (isset($component)) { $__componentOriginal84b78d66d5203b43b9d8c22236838526 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84b78d66d5203b43b9d8c22236838526 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Button::resolve(['type' => 'submit','label' => 'Generar Predicción','theme' => 'primary','icon' => 'fas fa-chart-line'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'btn-lg','id' => 'submitBtn']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal84b78d66d5203b43b9d8c22236838526)): ?>
<?php $attributes = $__attributesOriginal84b78d66d5203b43b9d8c22236838526; ?>
<?php unset($__attributesOriginal84b78d66d5203b43b9d8c22236838526); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal84b78d66d5203b43b9d8c22236838526)): ?>
<?php $component = $__componentOriginal84b78d66d5203b43b9d8c22236838526; ?>
<?php unset($__componentOriginal84b78d66d5203b43b9d8c22236838526); ?>
<?php endif; ?>
        <a href="<?php echo e(route('predictions.index')); ?>" class="btn btn-danger btn-lg"><i class="fas fa-times"></i> Cancelar</a>
    </div>
</div>

<?php $__env->startPush('css'); ?>
<style>
    #prediction-map {
        border-radius: 0;
    }
    
    .fire-marker-selected {
        filter: drop-shadow(0 0 10px #22c55e) drop-shadow(0 0 20px #22c55e);
        z-index: 1000 !important;
    }
    
    .custom-fire-marker {
        background: transparent !important;
        border: none !important;
    }
    
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar que Leaflet esté disponible
    if (typeof L === 'undefined') {
        console.warn('Leaflet no está cargado, reintentando...');
        setTimeout(arguments.callee, 100);
        return;
    }
    
    // Inicializar mapa
    const map = L.map('prediction-map').setView([-17.8857, -60.7556], 10);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 18,
    }).addTo(map);
    
    let selectedMarker = null;
    let allMarkers = [];
    
    // Función para crear icono de fuego
    function createFireIcon(fire, isSelected = false) {
        const confidence = fire.confidence || 'n';
        let color = '#ff6b35';
        if (confidence === 'h') color = '#dc2626';
        else if (confidence === 'l') color = '#fb923c';
        
        if (isSelected) color = '#22c55e'; // Verde cuando está seleccionado
        
        const iconSize = [28, 38];
        
        const iconHtml = `
            <div style="position: relative;">
                <div style="
                    background: ${color};
                    width: ${iconSize[0]}px;
                    height: ${iconSize[0]}px;
                    border-radius: 50% 50% 50% 0;
                    transform: rotate(-45deg);
                    border: 3px solid white;
                    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    ${isSelected ? 'animation: pulse-green 1.5s infinite;' : ''}
                ">
                    <i class="fas fa-fire" style="
                        color: white;
                        font-size: 14px;
                        transform: rotate(45deg);
                    "></i>
                </div>
            </div>
        `;
        
        return L.divIcon({
            html: iconHtml,
            className: 'custom-fire-marker' + (isSelected ? ' fire-marker-selected' : ''),
            iconSize: iconSize,
            iconAnchor: [iconSize[0]/2, iconSize[1]],
            popupAnchor: [0, -iconSize[1] + 5]
        });
    }
    
    // Función para seleccionar un foco
    async function selectFire(fire, marker) {
        // Resetear marcador anterior
        if (selectedMarker) {
            const prevFire = selectedMarker.fireData;
            selectedMarker.setIcon(createFireIcon(prevFire, false));
        }
        
        // Marcar nuevo como seleccionado
        selectedMarker = marker;
        marker.setIcon(createFireIcon(fire, true));
        
        // Calcular intensidad
        const frp = fire.frp || 5;
        const intensity = Math.min(5, Math.max(1, Math.round(frp / 50)));
        
        // Actualizar campos ocultos
        document.getElementById('fire_lat').value = fire.lat;
        document.getElementById('fire_lng').value = fire.lng;
        document.getElementById('fire_intensity').value = intensity;
        document.getElementById('fire_frp').value = frp;
        
        // Actualizar panel de información
        document.getElementById('selected-coords').textContent = `${fire.lat.toFixed(5)}, ${fire.lng.toFixed(5)}`;
        document.getElementById('selected-frp').textContent = `${frp.toFixed(1)} MW`;
        document.getElementById('selected-intensity').textContent = `${intensity}/5`;
        document.getElementById('selected-date').textContent = fire.date || 'N/A';
        
        const confidence = fire.confidence || 'n';
        const confidenceText = confidence === 'h' ? 'Alta' : confidence === 'l' ? 'Baja' : 'Normal';
        document.getElementById('selected-confidence').textContent = confidenceText;
        
        // Mostrar panel de selección
        document.getElementById('selected-fire-card').style.display = 'block';
        document.getElementById('no-fire-card').style.display = 'none';
        
        // Habilitar botón de submit
        document.getElementById('submitBtn').disabled = false;
        
        // Cerrar popup
        marker.closePopup();
        
        // Cargar automáticamente el clima del punto seleccionado
        await loadWeatherForCoords(fire.lat, fire.lng);
    }
    
    // Función para cargar clima de coordenadas específicas
    async function loadWeatherForCoords(lat, lng) {
        const loadWeatherBtn = document.getElementById('loadWeatherBtn');
        const temperatureInput = document.querySelector('input[name="temperature"]');
        const humidityInput = document.querySelector('input[name="humidity"]');
        const windSpeedInput = document.querySelector('input[name="wind_speed"]');
        const windDirectionInput = document.querySelector('input[name="wind_direction"]');
        
        loadWeatherBtn.disabled = true;
        const originalHtml = loadWeatherBtn.innerHTML;
        loadWeatherBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando clima...';

        try {
            const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lng}&current=temperature_2m,relative_humidity_2m,wind_speed_10m,wind_direction_10m&timezone=America/La_Paz`;
            const response = await fetch(url);
            
            if (!response.ok) throw new Error('Error al obtener datos del clima');
            
            const data = await response.json();
            
            temperatureInput.value = Math.round(data.current.temperature_2m * 10) / 10;
            humidityInput.value = Math.round(data.current.relative_humidity_2m * 10) / 10;
            windSpeedInput.value = Math.round(data.current.wind_speed_10m * 10) / 10;
            windDirectionInput.value = Math.round(data.current.wind_direction_10m);
            
            // Mostrar notificación de éxito
            Swal.fire({
                icon: 'success',
                title: 'Clima Cargado Automáticamente',
                html: `
                    <div style="text-align: left;">
                        <p><i class="fas fa-thermometer-half text-danger"></i> <strong>Temperatura:</strong> ${temperatureInput.value}°C</p>
                        <p><i class="fas fa-tint text-info"></i> <strong>Humedad:</strong> ${humidityInput.value}%</p>
                        <p><i class="fas fa-wind text-primary"></i> <strong>Viento:</strong> ${windSpeedInput.value} km/h</p>
                        <p><i class="fas fa-compass text-secondary"></i> <strong>Dirección:</strong> ${windDirectionInput.value}°</p>
                    </div>
                `,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            });
            
        } catch (error) {
            console.error('Error loading weather:', error);
            Swal.fire({
                icon: 'warning',
                title: 'Clima no disponible',
                text: 'No se pudo cargar el clima automáticamente. Puedes ingresarlo manualmente.',
                timer: 3000,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            });
        } finally {
            loadWeatherBtn.disabled = false;
            loadWeatherBtn.innerHTML = originalHtml;
        }
    }
    
    // Cargar focos de FIRMS
    fetch('/api/fires')
        .then(res => res.json())
        .then(result => {
            if (result.ok && result.data && result.data.length > 0) {
                console.log(`🔥 Cargados ${result.count} puntos calientes`);
                
                result.data.forEach(fire => {
                    const marker = L.marker(
                        [fire.lat, fire.lng],
                        { icon: createFireIcon(fire) }
                    ).addTo(map);
                    
                    marker.fireData = fire;
                    allMarkers.push(marker);
                    
                    // Crear popup con botón de selección
                    const popupContent = `
                        <div style="min-width: 200px;">
                            <h5 style="margin: 0 0 10px 0;"><i class="fas fa-fire text-danger"></i> Foco de Calor</h5>
                            <p style="margin: 5px 0;"><strong>Fecha:</strong> ${fire.date}</p>
                            <p style="margin: 5px 0;"><strong>Potencia:</strong> ${(fire.frp || 0).toFixed(1)} MW</p>
                            <p style="margin: 5px 0;"><strong>Ubicación:</strong> ${fire.lat.toFixed(4)}, ${fire.lng.toFixed(4)}</p>
                            <button type="button" class="btn btn-success btn-sm btn-block mt-2" onclick="window.selectFireMarker(${allMarkers.length - 1})">
                                <i class="fas fa-check"></i> Seleccionar este foco
                            </button>
                        </div>
                    `;
                    
                    marker.bindPopup(popupContent);
                    
                    // Click directo también selecciona
                    marker.on('dblclick', () => selectFire(fire, marker));
                });
                
                // Ajustar vista al primer foco si hay datos desde URL
                const urlLat = parseFloat(document.getElementById('fire_lat').value);
                const urlLng = parseFloat(document.getElementById('fire_lng').value);
                
                if (urlLat && urlLng) {
                    // Buscar el marcador más cercano a las coordenadas de la URL
                    let closestMarker = null;
                    let closestDist = Infinity;
                    
                    allMarkers.forEach(m => {
                        const dist = Math.sqrt(
                            Math.pow(m.fireData.lat - urlLat, 2) +
                            Math.pow(m.fireData.lng - urlLng, 2)
                        );
                        if (dist < closestDist) {
                            closestDist = dist;
                            closestMarker = m;
                        }
                    });
                    
                    if (closestMarker && closestDist < 0.01) {
                        selectFire(closestMarker.fireData, closestMarker);
                        map.setView([urlLat, urlLng], 12);
                    }
                }
            } else {
                document.getElementById('prediction-map').innerHTML = `
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f8f9fa;">
                        <div class="text-center text-muted">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <p>No hay focos de calor disponibles en este momento</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.error('Error loading fires:', err);
        });
    
    // Función global para seleccionar desde popup
    window.selectFireMarker = function(index) {
        const marker = allMarkers[index];
        if (marker) {
            selectFire(marker.fireData, marker);
        }
    };
    
    // Botón para recargar clima manualmente
    const loadWeatherBtn = document.getElementById('loadWeatherBtn');

    loadWeatherBtn.addEventListener('click', async function() {
        const lat = document.getElementById('fire_lat').value;
        const lng = document.getElementById('fire_lng').value;
        
        if (!lat || !lng) {
            Swal.fire({
                icon: 'warning',
                title: 'Selecciona un Foco',
                text: 'Primero debes seleccionar un foco de incendio en el mapa.',
                timer: 3000
            });
            return;
        }

        await loadWeatherForCoords(parseFloat(lat), parseFloat(lng));
    });
    
    // Validar antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        const lat = document.getElementById('fire_lat').value;
        const lng = document.getElementById('fire_lng').value;
        
        if (!lat || !lng) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Foco Requerido',
                text: 'Debes seleccionar un foco de incendio en el mapa antes de generar la predicción.',
            });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/prediction/form.blade.php ENDPATH**/ ?>