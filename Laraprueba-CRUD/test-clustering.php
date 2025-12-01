#!/usr/bin/env php
<?php
/**
 * Script para demostrar el clustering de focos de calor
 * Muestra la diferencia entre datos sin agrupar y agrupados
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\FirmsDataService;

$firmsService = app(FirmsDataService::class);

echo "\n";
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║      NASA FIRMS - Demostración de Clustering (3 días)       ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
echo "\n";

// 1. Obtener datos SIN clustering
echo "🔥 Obteniendo focos SIN agrupar...\n";
$resultRaw = $firmsService->getFireData('VIIRS_NOAA20_NRT', '-62.5,-18.5,-57.5,-14.5', 3, false);

echo "   ✅ Focos individuales detectados: {$resultRaw['count']}\n";
echo "\n";

// 2. Obtener datos CON clustering (radio 2km)
echo "🎯 Agrupando focos en puntos calientes (radio: 2km)...\n";
$resultClustered = $firmsService->getFireData('VIIRS_NOAA20_NRT', '-62.5,-18.5,-57.5,-14.5', 3, true, 2.0);

echo "   ✅ Puntos calientes identificados: {$resultClustered['count']}\n";
echo "\n";

// 3. Mostrar reducción
$reduction = $resultRaw['count'] - $resultClustered['count'];
$percentage = $resultRaw['count'] > 0 ? round(($reduction / $resultRaw['count']) * 100, 1) : 0;

echo "📊 RESUMEN:\n";
echo "   ┌─────────────────────────────────────────┐\n";
echo "   │ Focos individuales:     " . str_pad($resultRaw['count'], 15, ' ', STR_PAD_LEFT) . " │\n";
echo "   │ Puntos calientes:       " . str_pad($resultClustered['count'], 15, ' ', STR_PAD_LEFT) . " │\n";
echo "   │ Reducción:              " . str_pad($reduction, 15, ' ', STR_PAD_LEFT) . " │\n";
echo "   │ Porcentaje de agrupado: " . str_pad($percentage . '%', 15, ' ', STR_PAD_LEFT) . " │\n";
echo "   └─────────────────────────────────────────┘\n";
echo "\n";

// 4. Mostrar ejemplos de clusters
if ($resultClustered['count'] > 0) {
    echo "🔍 EJEMPLOS DE PUNTOS CALIENTES:\n";
    echo "   ┌────────────┬─────────────┬───────────┬──────────────────┐\n";
    echo "   │  Latitud   │  Longitud   │   Focos   │      Fecha       │\n";
    echo "   ├────────────┼─────────────┼───────────┼──────────────────┤\n";
    
    $clusters = array_filter($resultClustered['data'], fn($f) => ($f['is_cluster'] ?? false) && $f['cluster_size'] > 1);
    $clusters = array_slice($clusters, 0, 5);
    
    foreach ($clusters as $cluster) {
        $lat = str_pad(number_format($cluster['lat'], 4), 10, ' ', STR_PAD_LEFT);
        $lng = str_pad(number_format($cluster['lng'], 4), 11, ' ', STR_PAD_LEFT);
        $size = str_pad($cluster['cluster_size'], 9, ' ', STR_PAD_LEFT);
        $date = str_pad($cluster['date'], 16, ' ', STR_PAD_LEFT);
        echo "   │ {$lat} │ {$lng} │ {$size} │ {$date} │\n";
    }
    
    echo "   └────────────┴─────────────┴───────────┴──────────────────┘\n";
    echo "\n";
    
    // Estadísticas de clusters
    $clusterSizes = array_column(
        array_filter($resultClustered['data'], fn($f) => $f['is_cluster'] ?? false),
        'cluster_size'
    );
    
    if (!empty($clusterSizes)) {
        $avgSize = round(array_sum($clusterSizes) / count($clusterSizes), 1);
        $maxSize = max($clusterSizes);
        $singlePoints = count(array_filter($clusterSizes, fn($s) => $s === 1));
        $multiPoints = count($clusterSizes) - $singlePoints;
        
        echo "📈 ESTADÍSTICAS DE CLUSTERING:\n";
        echo "   - Tamaño promedio de cluster: {$avgSize} focos\n";
        echo "   - Cluster más grande: {$maxSize} focos agrupados\n";
        echo "   - Puntos individuales: {$singlePoints}\n";
        echo "   - Conglomerados: {$multiPoints}\n";
        echo "\n";
    }
}

echo "💡 BENEFICIOS DEL CLUSTERING:\n";
echo "   ✓ Reduce la cantidad de marcadores en el mapa\n";
echo "   ✓ Identifica zonas críticas de incendio\n";
echo "   ✓ Mejora el rendimiento de visualización\n";
echo "   ✓ Facilita la toma de decisiones\n";
echo "\n";

echo "════════════════════════════════════════════════════════════════\n";
echo "\n";
