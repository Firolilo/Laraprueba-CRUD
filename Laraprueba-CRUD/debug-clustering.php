#!/usr/bin/env php
<?php
/**
 * Script para debugging del clustering
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\FirmsDataService;

$firmsService = app(FirmsDataService::class);

echo "🔍 Analizando distancias entre focos...\n\n";

// Obtener datos sin clustering
$result = $firmsService->getFireData('VIIRS_NOAA20_NRT', '-62.5,-18.5,-57.5,-14.5', 3, false);

if ($result['count'] < 2) {
    echo "No hay suficientes datos para analizar.\n";
    exit;
}

$fires = $result['data'];

// Analizar primeros 10 focos
$sample = array_slice($fires, 0, 10);

echo "Muestra de primeros 10 focos:\n";
foreach ($sample as $i => $fire) {
    echo sprintf("[%d] Lat: %.4f, Lng: %.4f\n", $i, $fire['lat'], $fire['lng']);
}

echo "\nDistancias entre primeros 5 pares:\n";
for ($i = 0; $i < min(5, count($sample)); $i++) {
    for ($j = $i + 1; $j < min(5, count($sample)); $j++) {
        $distance = haversineDistance(
            $sample[$i]['lat'], $sample[$i]['lng'],
            $sample[$j]['lat'], $sample[$j]['lng']
        );
        echo sprintf("  [%d]-[%d]: %.2f km\n", $i, $j, $distance);
    }
}

function haversineDistance($lat1, $lng1, $lat2, $lng2) {
    $earthRadius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLng = deg2rad($lng2 - $lng1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLng / 2) * sin($dLng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
}

echo "\n";
