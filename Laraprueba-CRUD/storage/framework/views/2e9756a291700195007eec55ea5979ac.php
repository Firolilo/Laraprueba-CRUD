<div class="row">
    <div class="col-md-6">
        <?php if (isset($component)) { $__componentOriginale5d826ae10df3aa87f8449f474c11664 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5d826ae10df3aa87f8449f474c11664 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Input::resolve(['name' => 'fecha','label' => 'Fecha','enableOldSupport' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'datetime-local','value' => ''.e(old('fecha', optional($focosIncendio->fecha)->format('Y-m-d\TH:i'))).'']); ?>
             <?php $__env->slot('prependSlot', null, []); ?> 
                <div class="input-group-text">
                    <i class="fas fa-calendar text-danger"></i>
                </div>
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
    <div class="col-md-6">
        <?php if (isset($component)) { $__componentOriginale5d826ae10df3aa87f8449f474c11664 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5d826ae10df3aa87f8449f474c11664 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Input::resolve(['name' => 'ubicacion','label' => 'Ubicación','enableOldSupport' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Nombre del lugar','value' => ''.e(old('ubicacion', $focosIncendio->ubicacion)).'']); ?>
             <?php $__env->slot('prependSlot', null, []); ?> 
                <div class="input-group-text">
                    <i class="fas fa-map-marker-alt text-danger"></i>
                </div>
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

    <div class="col-md-6">
        <?php if (isset($component)) { $__componentOriginale5d826ae10df3aa87f8449f474c11664 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5d826ae10df3aa87f8449f474c11664 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Input::resolve(['name' => 'intensidad','label' => 'Intensidad','enableOldSupport' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','step' => '0.01','value' => ''.e(old('intensidad', $focosIncendio->intensidad)).'']); ?>
             <?php $__env->slot('prependSlot', null, []); ?> 
                <div class="input-group-text">
                    <i class="fas fa-fire text-danger"></i>
                </div>
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
    <div class="col-md-6">
        <div class="form-group">
            <label for="coordenadas">Coordenadas [lat, lng]</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-location-arrow text-danger"></i>
                    </span>
                </div>
                <input type="text" name="coordenadas" id="coordenadas" 
                    class="form-control <?php $__errorArgs = ['coordenadas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                    value="<?php echo e(old('coordenadas', $focosIncendio->coordenadas ? json_encode($focosIncendio->coordenadas) : '')); ?>" 
                    placeholder='[-17.8, -61.5]' readonly>
                <?php $__errorArgs = ['coordenadas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
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

    <div class="col-12 mt-3">
        <?php if (isset($component)) { $__componentOriginal84b78d66d5203b43b9d8c22236838526 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84b78d66d5203b43b9d8c22236838526 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Form\Button::resolve(['type' => 'submit','label' => 'Guardar','theme' => 'primary','icon' => 'fas fa-save'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Form\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
        <a href="<?php echo e(route('focos-incendios.index')); ?>" class="btn btn-danger "><i class="fas fa-arrow-left"></i> Cancelar</a>
    </div>
</div>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-container {
        cursor: crosshair;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
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
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/focos-incendio/form.blade.php ENDPATH**/ ?>