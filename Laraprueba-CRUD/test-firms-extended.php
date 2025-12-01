#!/usr/bin/env php
<?php
/**
 * Script de prueba extendida para NASA FIRMS API
 * Prueba con diferentes rangos de días
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\FirmsDataService;

$firmsService = app(FirmsDataService::class);

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║        NASA FIRMS API - Test con Múltiples Días           ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

$daysToTest = [1, 3, 7];

foreach ($daysToTest as $days) {
    echo "🔍 Probando con {$days} día(s)...\n";
    
    $result = $firmsService->getFireData('VIIRS_NOAA20_NRT', '-62.5,-18.5,-57.5,-14.5', $days);
    
    if ($result['ok']) {
        echo "   ✅ Focos detectados: {$result['count']}\n";
        
        if ($result['count'] > 0) {
            echo "   📅 Muestra de fechas:\n";
            $dates = array_unique(array_column(array_slice($result['data'], 0, 10), 'date'));
            foreach ($dates as $date) {
                $count = count(array_filter($result['data'], fn($f) => $f['date'] === $date));
                echo "      - {$date}: {$count} foco(s)\n";
            }
        }
    } else {
        echo "   ❌ Error: {$result['error']}\n";
    }
    
    echo "\n";
}

echo "═══════════════════════════════════════════════════════════\n";
echo "\n";
