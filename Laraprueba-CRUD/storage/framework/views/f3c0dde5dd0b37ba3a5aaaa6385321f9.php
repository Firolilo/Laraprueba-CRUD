<?php $__env->startSection('subtitle', 'Datos Climáticos'); ?>
<?php $__env->startSection('content_header_title', 'Datos Climáticos Históricos -'); ?>
<?php $__env->startSection('content_header_subtitle'); ?>
    <?php echo e($ubicacion); ?> - Última Semana
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_body'); ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Período:</strong> <?php echo e($fechaInicio->format('d/m/Y')); ?> - <?php echo e($fechaFin->format('d/m/Y')); ?>

                <span class="float-right">
                    <i class="fas fa-map-marker-alt"></i> <?php echo e($ubicacion); ?>

                </span>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-3">
            <?php if (isset($component)) { $__componentOriginal28a68399664384fcdb4ffafd23cbfe61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal28a68399664384fcdb4ffafd23cbfe61 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\SmallBox::resolve(['title' => ''.e(number_format(max($datosGraficas['temperatura']), 1)).'°C','text' => 'Temperatura Máxima','icon' => 'fas fa-temperature-high','theme' => 'danger'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-small-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\SmallBox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal28a68399664384fcdb4ffafd23cbfe61)): ?>
<?php $attributes = $__attributesOriginal28a68399664384fcdb4ffafd23cbfe61; ?>
<?php unset($__attributesOriginal28a68399664384fcdb4ffafd23cbfe61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal28a68399664384fcdb4ffafd23cbfe61)): ?>
<?php $component = $__componentOriginal28a68399664384fcdb4ffafd23cbfe61; ?>
<?php unset($__componentOriginal28a68399664384fcdb4ffafd23cbfe61); ?>
<?php endif; ?>
        </div>
        <div class="col-md-3">
            <?php if (isset($component)) { $__componentOriginal28a68399664384fcdb4ffafd23cbfe61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal28a68399664384fcdb4ffafd23cbfe61 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\SmallBox::resolve(['title' => ''.e(number_format(max($datosGraficas['humedad']), 0)).'%','text' => 'Humedad Máxima','icon' => 'fas fa-tint','theme' => 'info'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-small-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\SmallBox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal28a68399664384fcdb4ffafd23cbfe61)): ?>
<?php $attributes = $__attributesOriginal28a68399664384fcdb4ffafd23cbfe61; ?>
<?php unset($__attributesOriginal28a68399664384fcdb4ffafd23cbfe61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal28a68399664384fcdb4ffafd23cbfe61)): ?>
<?php $component = $__componentOriginal28a68399664384fcdb4ffafd23cbfe61; ?>
<?php unset($__componentOriginal28a68399664384fcdb4ffafd23cbfe61); ?>
<?php endif; ?>
        </div>
        <div class="col-md-3">
            <?php if (isset($component)) { $__componentOriginal28a68399664384fcdb4ffafd23cbfe61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal28a68399664384fcdb4ffafd23cbfe61 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\SmallBox::resolve(['title' => ''.e(number_format(array_sum($datosGraficas['precipitacion']), 1)).' mm','text' => 'Precipitación Total','icon' => 'fas fa-cloud-rain','theme' => 'primary'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-small-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\SmallBox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal28a68399664384fcdb4ffafd23cbfe61)): ?>
<?php $attributes = $__attributesOriginal28a68399664384fcdb4ffafd23cbfe61; ?>
<?php unset($__attributesOriginal28a68399664384fcdb4ffafd23cbfe61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal28a68399664384fcdb4ffafd23cbfe61)): ?>
<?php $component = $__componentOriginal28a68399664384fcdb4ffafd23cbfe61; ?>
<?php unset($__componentOriginal28a68399664384fcdb4ffafd23cbfe61); ?>
<?php endif; ?>
        </div>
        <div class="col-md-3">
            <?php if (isset($component)) { $__componentOriginal28a68399664384fcdb4ffafd23cbfe61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal28a68399664384fcdb4ffafd23cbfe61 = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\SmallBox::resolve(['title' => ''.e(number_format(max($datosGraficas['viento']), 1)).' km/h','text' => 'Viento Máximo','icon' => 'fas fa-wind','theme' => 'success'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-small-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\SmallBox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal28a68399664384fcdb4ffafd23cbfe61)): ?>
<?php $attributes = $__attributesOriginal28a68399664384fcdb4ffafd23cbfe61; ?>
<?php unset($__attributesOriginal28a68399664384fcdb4ffafd23cbfe61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal28a68399664384fcdb4ffafd23cbfe61)): ?>
<?php $component = $__componentOriginal28a68399664384fcdb4ffafd23cbfe61; ?>
<?php unset($__componentOriginal28a68399664384fcdb4ffafd23cbfe61); ?>
<?php endif; ?>
        </div>
    </div>

    
    <div class="row">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::resolve(['title' => 'Temperatura Horaria','theme' => 'danger','icon' => 'fas fa-temperature-high'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <canvas id="temperaturaChart" height="80"></canvas>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $attributes = $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $component = $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
        </div>
    </div>

    
    <div class="row">
        <div class="col-lg-6">
            <?php if (isset($component)) { $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::resolve(['title' => 'Humedad Relativa','theme' => 'info','icon' => 'fas fa-tint'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <canvas id="humedadChart" height="120"></canvas>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $attributes = $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $component = $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
        </div>
        <div class="col-lg-6">
            <?php if (isset($component)) { $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::resolve(['title' => 'Precipitación Acumulada','theme' => 'primary','icon' => 'fas fa-cloud-rain'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <canvas id="precipitacionChart" height="120"></canvas>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $attributes = $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $component = $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
        </div>
    </div>

    
    <div class="row">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b = $attributes; } ?>
<?php $component = JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::resolve(['title' => 'Velocidad del Viento','theme' => 'success','icon' => 'fas fa-wind'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <canvas id="vientoChart" height="80"></canvas>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $attributes = $__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__attributesOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b)): ?>
<?php $component = $__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b; ?>
<?php unset($__componentOriginale2b5538aaf81eaeffb0a99a88907fd7b); ?>
<?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Datos del backend
    const datosGraficas = <?php echo json_encode($datosGraficas, 15, 512) ?>;
    
    // Formatear labels para mostrar solo fecha/hora legible
    const labels = datosGraficas.labels.map(label => {
        const fecha = new Date(label);
        const dia = fecha.getDate().toString().padStart(2, '0');
        const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
        const hora = fecha.getHours().toString().padStart(2, '0');
        return `${dia}/${mes} ${hora}:00`;
    });
    
    // Configuración común para todas las gráficas
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            x: {
                ticks: {
                    maxRotation: 45,
                    minRotation: 45,
                    maxTicksLimit: 24 // Mostrar máximo 24 etiquetas
                }
            }
        }
    };
    
    // Gráfica de Temperatura
    new Chart(document.getElementById('temperaturaChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Temperatura (°C)',
                data: datosGraficas.temperatura,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Temperatura (°C)'
                    }
                }
            }
        }
    });
    
    // Gráfica de Humedad
    new Chart(document.getElementById('humedadChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Humedad (%)',
                data: datosGraficas.humedad,
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Humedad (%)'
                    }
                }
            }
        }
    });
    
    // Gráfica de Precipitación
    new Chart(document.getElementById('precipitacionChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Precipitación (mm)',
                data: datosGraficas.precipitacion,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Precipitación (mm)'
                    }
                }
            }
        }
    });
    
    // Gráfica de Viento
    new Chart(document.getElementById('vientoChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Velocidad del Viento (km/h)',
                data: datosGraficas.viento,
                borderColor: 'rgb(75, 192, 75)',
                backgroundColor: 'rgba(75, 192, 75, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                ...commonOptions.scales,
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Velocidad (km/h)'
                    }
                }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/datos-climaticos/index.blade.php ENDPATH**/ ?>