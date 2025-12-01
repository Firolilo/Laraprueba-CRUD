#!/usr/bin/env php
<?php
/**
 * Comparación de diferentes radios de clustering
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\FirmsDataService;

$firmsService = app(FirmsDataService::class);

echo "\n";
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║    Comparación de Radios de Clustering (últimos 3 días)     ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n";
echo "\n";

// Obtener datos sin clustering
$resultRaw = $firmsService->getFireData('VIIRS_NOAA20_NRT', '-62.5,-18.5,-57.5,-14.5', 3, false);
$totalFires = $resultRaw['count'];

echo "🔥 Total de focos individuales: {$totalFires}\n";
echo "\n";

$radii = [0.5, 1.0, 2.0, 5.0, 10.0];

echo "📊 RESULTADOS POR RADIO:\n";
echo "┌────────────┬─────────────┬────────────┬──────────────────┐\n";
echo "│   Radio    │   Puntos    │ Reducción  │    Porcentaje    │\n";
echo "├────────────┼─────────────┼────────────┼──────────────────┤\n";

foreach ($radii as $radius) {
    $result = $firmsService->getFireData('VIIRS_NOAA20_NRT', '-62.5,-18.5,-57.5,-14.5', 3, true, $radius);
    
    $hotspots = $result['count'];
    $reduction = $totalFires - $hotspots;
    $percentage = $totalFires > 0 ? round(($reduction / $totalFires) * 100, 1) : 0;
    
    $radiusStr = str_pad($radius . ' km', 10, ' ', STR_PAD_LEFT);
    $hotspotsStr = str_pad($hotspots, 11, ' ', STR_PAD_LEFT);
    $reductionStr = str_pad($reduction, 10, ' ', STR_PAD_LEFT);
    $percentageStr = str_pad($percentage . '%', 16, ' ', STR_PAD_LEFT);
    
    echo "│ {$radiusStr} │ {$hotspotsStr} │ {$reductionStr} │ {$percentageStr} │\n";
}

echo "└────────────┴─────────────┴────────────┴──────────────────┘\n";
echo "\n";

echo "💡 RECOMENDACIÓN:\n";
echo "   • 0.5-1 km: Para análisis detallado de zonas específicas\n";
echo "   • 2 km: Balance óptimo para visualización general ✓\n";
echo "   • 5-10 km: Para vista panorámica de regiones amplias\n";
echo "\n";

echo "════════════════════════════════════════════════════════════════\n";
echo "\n";
