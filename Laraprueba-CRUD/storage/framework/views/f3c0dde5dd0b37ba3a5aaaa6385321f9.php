<?php $__env->startSection('subtitle', 'Datos Climáticos'); ?>
<?php $__env->startSection('content_header_title', 'Datos Climáticos Históricos'); ?>
<?php $__env->startSection('content_header_subtitle'); ?>
    Región Chiquitanía - Última Semana
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_body'); ?>
    
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info mb-0 py-2 d-flex align-items-center justify-content-between">
                <div>
                    <i class="fas fa-calendar-alt"></i>
                    <strong>Período:</strong> Últimos 7 días
                    <span id="loading-indicator" class="ml-3 text-primary" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Cargando...
                    </span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <select id="ubicacion-select" class="form-control form-control-sm" style="width: auto; min-width: 200px;">
                        <?php $__currentLoopData = $ubicaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ubic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" 
                                    data-lat="<?php echo e($ubic['lat']); ?>" 
                                    data-lng="<?php echo e($ubic['lng']); ?>"
                                    <?php echo e($ubicacionKey === $key ? 'selected' : ''); ?>>
                                <?php echo e($ubic['nombre']); ?>, Bolivia
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row" id="summary-cards">
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="temp-max"><?php echo e(number_format(max($datosGraficas['temperatura']), 1)); ?>°C</h3>
                    <p>Temperatura Máxima</p>
                </div>
                <div class="icon"><i class="fas fa-temperature-high"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="humidity-max"><?php echo e(number_format(max($datosGraficas['humedad']), 0)); ?>%</h3>
                    <p>Humedad Máxima</p>
                </div>
                <div class="icon"><i class="fas fa-tint"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3 id="precip-total"><?php echo e(number_format(array_sum($datosGraficas['precipitacion']), 1)); ?> mm</h3>
                    <p>Precipitación Total</p>
                </div>
                <div class="icon"><i class="fas fa-cloud-rain"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="wind-max"><?php echo e(number_format(max($datosGraficas['viento']), 1)); ?> km/h</h3>
                    <p>Viento Máximo</p>
                </div>
                <div class="icon"><i class="fas fa-wind"></i></div>
            </div>
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

<?php $__env->startPush('css'); ?>
<style>
    #ubicacion-select {
        transition: all 0.3s ease;
        font-weight: 500;
    }
    #ubicacion-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .small-box h3 {
        transition: all 0.4s ease;
    }
    .chart-updating {
        opacity: 0.4;
        transition: opacity 0.3s ease;
    }
    #loading-indicator {
        animation: pulse 1s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos iniciales
    let currentData = <?php echo json_encode($datosGraficas, 15, 512) ?>;
    const ubicaciones = <?php echo json_encode($ubicaciones, 15, 512) ?>;
    
    // Referencias a los charts
    let tempChart, humChart, precipChart, windChart;
    
    // Formatear labels
    function formatLabels(labels) {
        return labels.map(label => {
            const fecha = new Date(label);
            const dia = fecha.getDate().toString().padStart(2, '0');
            const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
            const hora = fecha.getHours().toString().padStart(2, '0');
            return `${dia}/${mes} ${hora}:00`;
        });
    }
    
    // Configuración común
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: true,
        animation: { duration: 600, easing: 'easeInOutQuart' },
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            x: { ticks: { maxRotation: 45, minRotation: 45, maxTicksLimit: 24 } }
        }
    };
    
    // Inicializar gráficas
    function initCharts() {
        const labels = formatLabels(currentData.labels);
        
        tempChart = new Chart(document.getElementById('temperaturaChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Temperatura (°C)',
                    data: currentData.temperatura,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.1)',
                    fill: true, tension: 0.4
                }]
            },
            options: { ...commonOptions, scales: { ...commonOptions.scales, y: { beginAtZero: false, title: { display: true, text: 'Temperatura (°C)' } } } }
        });
        
        humChart = new Chart(document.getElementById('humedadChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Humedad (%)',
                    data: currentData.humedad,
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    fill: true, tension: 0.4
                }]
            },
            options: { ...commonOptions, scales: { ...commonOptions.scales, y: { beginAtZero: true, max: 100, title: { display: true, text: 'Humedad (%)' } } } }
        });
        
        precipChart = new Chart(document.getElementById('precipitacionChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Precipitación (mm)',
                    data: currentData.precipitacion,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgb(75, 192, 192)', borderWidth: 1
                }]
            },
            options: { ...commonOptions, scales: { ...commonOptions.scales, y: { beginAtZero: true, title: { display: true, text: 'Precipitación (mm)' } } } }
        });
        
        windChart = new Chart(document.getElementById('vientoChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Velocidad del Viento (km/h)',
                    data: currentData.viento,
                    borderColor: 'rgb(75, 192, 75)',
                    backgroundColor: 'rgba(75, 192, 75, 0.1)',
                    fill: true, tension: 0.4
                }]
            },
            options: { ...commonOptions, scales: { ...commonOptions.scales, y: { beginAtZero: true, title: { display: true, text: 'Velocidad (km/h)' } } } }
        });
    }
    
    // Actualizar gráficas con animación fluida
    function updateCharts(data) {
        const labels = formatLabels(data.labels);
        
        [tempChart, humChart, precipChart, windChart].forEach((chart, i) => {
            chart.data.labels = labels;
            chart.data.datasets[0].data = [data.temperatura, data.humedad, data.precipitacion, data.viento][i];
            chart.update('active');
        });
    }
    
    // Actualizar cards de resumen
    function updateSummaryCards(data) {
        document.getElementById('temp-max').textContent = Math.max(...data.temperatura).toFixed(1) + '°C';
        document.getElementById('humidity-max').textContent = Math.max(...data.humedad).toFixed(0) + '%';
        document.getElementById('precip-total').textContent = data.precipitacion.reduce((a, b) => a + b, 0).toFixed(1) + ' mm';
        document.getElementById('wind-max').textContent = Math.max(...data.viento).toFixed(1) + ' km/h';
    }
    
    // Cargar datos usando Open-Meteo API directamente
    async function loadWeatherData(lat, lng, nombreUbicacion) {
        const loading = document.getElementById('loading-indicator');
        
        loading.style.display = 'inline';
        document.querySelectorAll('canvas').forEach(c => c.classList.add('chart-updating'));
        
        try {
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(startDate.getDate() - 7);
            
            const fmt = d => d.toISOString().split('T')[0];
            const url = `https://archive-api.open-meteo.com/v1/archive?latitude=${lat}&longitude=${lng}&start_date=${fmt(startDate)}&end_date=${fmt(endDate)}&hourly=temperature_2m,relative_humidity_2m,precipitation,wind_speed_10m&timezone=America/La_Paz`;
            
            const response = await fetch(url);
            const result = await response.json();
            
            if (result.hourly) {
                const newData = {
                    labels: result.hourly.time || [],
                    temperatura: result.hourly.temperature_2m || [],
                    humedad: result.hourly.relative_humidity_2m || [],
                    precipitacion: result.hourly.precipitation || [],
                    viento: result.hourly.wind_speed_10m || []
                };
                
                currentData = newData;
                updateCharts(newData);
                updateSummaryCards(newData);
            }
        } catch (error) {
            console.error('Error:', error);
        } finally {
            loading.style.display = 'none';
            document.querySelectorAll('canvas').forEach(c => c.classList.remove('chart-updating'));
        }
    }
    
    // Event listener para cambio de ubicación
    document.getElementById('ubicacion-select').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        loadWeatherData(opt.dataset.lat, opt.dataset.lng, opt.textContent.trim());
    });
    
    initCharts();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/datos-climaticos/index.blade.php ENDPATH**/ ?>