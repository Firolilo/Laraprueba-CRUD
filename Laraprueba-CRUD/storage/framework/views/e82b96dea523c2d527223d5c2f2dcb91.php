<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Predicción - SIPII</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1e40af;
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            color: #64748b;
            margin: 10px 0 0 0;
            font-size: 16px;
            font-weight: normal;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            border-left: 4px solid #2563eb;
            margin-bottom: 15px;
        }
        .info-row {
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-label {
            display: inline-block;
            width: 180px;
            font-weight: bold;
            color: #374151;
        }
        .info-value {
            color: #1f2937;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th {
            background-color: #e5e7eb;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        table td {
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            color: #1f2937;
        }
        table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
        .highlight {
            background-color: #fef3c7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIPII - Sistema de Predicción de Incendios</h1>
        <h2>Informe de Predicción de Incendio</h2>
    </div>

    <div class="section">
        <div class="section-title">Información del Foco de Incendio</div>
        <div class="info-row">
            <span class="info-label">Ubicación:</span>
            <span class="info-value"><?php echo e($prediction->focoIncendio->ubicacion ?? 'No disponible'); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Fecha del Foco:</span>
            <span class="info-value"><?php echo e(\Carbon\Carbon::parse($prediction->focoIncendio->fecha)->format('d/m/Y H:i')); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Intensidad:</span>
            <span class="info-value"><?php echo e($prediction->focoIncendio->intensidad ?? 'N/A'); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Duración de Predicción:</span>
            <span class="info-value"><?php echo e(count($path)); ?> horas</span>
        </div>
        <div class="info-row">
            <span class="info-label">Fecha de Generación:</span>
            <span class="info-value"><?php echo e(now()->format('d/m/Y H:i:s')); ?></span>
        </div>
    </div>

    <?php if(count($path) > 0): ?>
    <div class="section">
        <div class="section-title">Parámetros de Propagación</div>
        
        <?php
            $firstPoint = $path[0];
            $lastPoint = count($path) > 1 ? $path[count($path) - 1] : $firstPoint;
        ?>

        <table>
            <thead>
                <tr>
                    <th>Parámetro</th>
                    <th>Estado Inicial</th>
                    <th>Estado Final</th>
                    <th>Variación</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Intensidad</strong></td>
                    <td><?php echo e($firstPoint['intensity'] ?? 'N/A'); ?></td>
                    <td><?php echo e($lastPoint['intensity'] ?? 'N/A'); ?></td>
                    <td>
                        <?php if(isset($firstPoint['intensity']) && isset($lastPoint['intensity'])): ?>
                            <?php echo e(number_format(($lastPoint['intensity'] - $firstPoint['intensity']) / $firstPoint['intensity'] * 100, 2)); ?>%
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Radio de Propagación (km)</strong></td>
                    <td><?php echo e(number_format($firstPoint['spread_radius_km'] ?? 0, 2)); ?></td>
                    <td><?php echo e(number_format($lastPoint['spread_radius_km'] ?? 0, 2)); ?></td>
                    <td>
                        <?php if(isset($firstPoint['spread_radius_km']) && isset($lastPoint['spread_radius_km']) && $firstPoint['spread_radius_km'] > 0): ?>
                            +<?php echo e(number_format($lastPoint['spread_radius_km'] - $firstPoint['spread_radius_km'], 2)); ?> km
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Área Afectada (km²)</strong></td>
                    <td><?php echo e(number_format($firstPoint['affected_area_km2'] ?? 0, 2)); ?></td>
                    <td><?php echo e(number_format($lastPoint['affected_area_km2'] ?? 0, 2)); ?></td>
                    <td>
                        <?php if(isset($firstPoint['affected_area_km2']) && isset($lastPoint['affected_area_km2']) && $firstPoint['affected_area_km2'] > 0): ?>
                            +<?php echo e(number_format($lastPoint['affected_area_km2'] - $firstPoint['affected_area_km2'], 2)); ?> km²
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Perímetro (km)</strong></td>
                    <td><?php echo e(number_format($firstPoint['perimeter_km'] ?? 0, 2)); ?></td>
                    <td><?php echo e(number_format($lastPoint['perimeter_km'] ?? 0, 2)); ?></td>
                    <td>
                        <?php if(isset($firstPoint['perimeter_km']) && isset($lastPoint['perimeter_km']) && $firstPoint['perimeter_km'] > 0): ?>
                            +<?php echo e(number_format($lastPoint['perimeter_km'] - $firstPoint['perimeter_km'], 2)); ?> km
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Trayectoria Detallada (Primeros <?php echo e(min(count($path), 20)); ?> puntos)</div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">Hora</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Intensidad</th>
                    <th>Área (km²)</th>
                    <th>Radio (km)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = array_slice($path, 0, 20); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($point['hour'] ?? $index); ?></td>
                    <td><?php echo e(number_format($point['lat'] ?? 0, 4)); ?></td>
                    <td><?php echo e(number_format($point['lng'] ?? 0, 4)); ?></td>
                    <td><?php echo e(number_format($point['intensity'] ?? 0, 2)); ?></td>
                    <td><?php echo e(number_format($point['affected_area_km2'] ?? 0, 2)); ?></td>
                    <td><?php echo e(number_format($point['spread_radius_km'] ?? 0, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        
        <?php if(count($path) > 20): ?>
        <p style="margin-top: 10px; font-style: italic; color: #64748b;">
            + <?php echo e(count($path) - 20); ?> puntos adicionales no mostrados en este informe
        </p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="footer">
        <p><strong>SIPII - Sistema Integrado de Predicción de Incendios</strong></p>
        <p>Este informe fue generado automáticamente el <?php echo e(now()->format('d/m/Y H:i:s')); ?></p>
        <p>San José de Chiquitos, Bolivia</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views/pdfs/prediction.blade.php ENDPATH**/ ?>