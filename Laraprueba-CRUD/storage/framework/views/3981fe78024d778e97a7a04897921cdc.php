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
            <p class="mb-0">Seleccione un foco de incendio existente y configure los parámetros ambientales para generar una predicción de su propagación.</p>
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

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="foco_incendio_id" class="form-label">
                <i class="fas fa-fire text-danger"></i> Foco de Incendio <span class="text-danger">*</span>
            </label>
            <select name="foco_incendio_id" id="foco_incendio_id" class="form-control <?php $__errorArgs = ['foco_incendio_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <option value="">Seleccione un foco...</option>
                <?php $__currentLoopData = $focosIncendios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        // Manejar coordenadas tanto como array [lat, lng] como objeto {lat, lng}
                        $coords = $foco->coordenadas;
                        $lat = '';
                        $lng = '';
                        
                        if (is_array($coords)) {
                            $lat = $coords[0] ?? ($coords['lat'] ?? '');
                            $lng = $coords[1] ?? ($coords['lng'] ?? '');
                        }
                        
                        // Solo mostrar focos con coordenadas válidas
                        $hasCoords = !empty($lat) && !empty($lng);
                    ?>
                    
                    <?php if($hasCoords): ?>
                        <option value="<?php echo e($foco->id); ?>" 
                                data-lat="<?php echo e($lat); ?>" 
                                data-lng="<?php echo e($lng); ?>"
                                data-intensity="<?php echo e($foco->intensidad ?? 5); ?>"
                                <?php echo e(old('foco_incendio_id', $prediction?->foco_incendio_id) == $foco->id ? 'selected' : ''); ?>>
                            <?php echo e($foco->ubicacion); ?> - <?php echo e($foco->fecha?->format('d/m/Y H:i')); ?> (Intensidad: <?php echo e($foco->intensidad); ?>)
                        </option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php echo $errors->first('foco_incendio_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>'); ?>

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
<?php $component->withAttributes(['class' => 'btn-lg']); ?>
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
        <a href="<?php echo e(route('predictions.index')); ?>" class="btn btn-danger class="btn-lg""><i class="fas fa-times"></i> Cancelar</a>
    </div>
</div>

<?php $__env->startPush('js'); ?>
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

    // Cargar datos del clima desde Open-Meteo
    const loadWeatherBtn = document.getElementById('loadWeatherBtn');
    const temperatureInput = document.querySelector('input[name="temperature"]');
    const humidityInput = document.querySelector('input[name="humidity"]');
    const windSpeedInput = document.querySelector('input[name="wind_speed"]');
    const windDirectionInput = document.querySelector('input[name="wind_direction"]');

    loadWeatherBtn.addEventListener('click', async function() {
        const selectedOption = focoSelect.options[focoSelect.selectedIndex];
        
        if (!selectedOption.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Selecciona un Foco',
                text: 'Primero debes seleccionar un foco de incendio para obtener las coordenadas.',
                timer: 3000
            });
            return;
        }

        const lat = selectedOption.getAttribute('data-lat');
        const lng = selectedOption.getAttribute('data-lng');

        if (!lat || !lng) {
            Swal.fire({
                icon: 'error',
                title: 'Sin Coordenadas',
                text: 'El foco seleccionado no tiene coordenadas definidas.',
                timer: 3000
            });
            return;
        }

        // Mostrar loading
        loadWeatherBtn.disabled = true;
        const originalHtml = loadWeatherBtn.innerHTML;
        loadWeatherBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...';

        try {
            // Llamar a la API de Open-Meteo
            const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lng}&current=temperature_2m,relative_humidity_2m,wind_speed_10m,wind_direction_10m&timezone=America/La_Paz`;
            
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error('Error al obtener datos del clima');
            }
            
            const data = await response.json();
            
            // Actualizar campos del formulario con datos actuales
            temperatureInput.value = Math.round(data.current.temperature_2m * 10) / 10;
            humidityInput.value = Math.round(data.current.relative_humidity_2m * 10) / 10;
            windSpeedInput.value = Math.round(data.current.wind_speed_10m * 10) / 10;
            windDirectionInput.value = Math.round(data.current.wind_direction_10m);
            
            // Notificar éxito con datos
            Swal.fire({
                icon: 'success',
                title: 'Clima Cargado',
                html: `
                    <div style="text-align: left;">
                        <p><i class="fas fa-thermometer-half text-danger"></i> <strong>Temperatura:</strong> ${temperatureInput.value}°C</p>
                        <p><i class="fas fa-tint text-info"></i> <strong>Humedad:</strong> ${humidityInput.value}%</p>
                        <p><i class="fas fa-wind text-primary"></i> <strong>Viento:</strong> ${windSpeedInput.value} km/h</p>
                        <p><i class="fas fa-compass text-secondary"></i> <strong>Dirección:</strong> ${windDirectionInput.value}°</p>
                        <hr>
                        <small class="text-muted">Datos obtenidos de Open-Meteo para las coordenadas del foco</small>
                    </div>
                `,
                timer: 5000,
                timerProgressBar: true
            });
            
        } catch (error) {
            console.error('Error loading weather:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar datos climáticos. Intenta nuevamente.',
                timer: 3000
            });
        } finally {
            loadWeatherBtn.disabled = false;
            loadWeatherBtn.innerHTML = originalHtml;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/prediction/form.blade.php ENDPATH**/ ?>