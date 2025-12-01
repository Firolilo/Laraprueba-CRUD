#!/usr/bin/env php
<?php
/**
 * Script de prueba para NASA FIRMS API
 * 
 * Uso:
 *   php test-firms-api.php
 * 
 * Verifica que el servicio FirmsDataService funcione correctamente
 * con el nuevo endpoint de área.
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\FirmsDataService;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║           NASA FIRMS API - Test de Conexión               ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

$firmsService = app(FirmsDataService::class);

echo "📍 Área de prueba: Chiquitanía, Santa Cruz, Bolivia\n";
echo "   Coordenadas: -62.5,-18.5,-57.5,-14.5 (west,south,east,north)\n";
echo "\n";

echo "🔄 Consultando API de NASA FIRMS...\n";
echo "   Producto: VIIRS_NOAA20_NRT\n";
echo "   Días: 1 (hoy)\n";
echo "\n";

$startTime = microtime(true);
$result = $firmsService->getFireData('VIIRS_NOAA20_NRT', '-62.5,-18.5,-57.5,-14.5', 1);
$endTime = microtime(true);
$duration = round(($endTime - $startTime) * 1000, 2);

echo "⏱️  Tiempo de respuesta: {$duration}ms\n";
echo "\n";

if ($result['ok']) {
    echo "✅ Conexión exitosa!\n";
    echo "\n";
    echo "📊 Resultados:\n";
    echo "   - Status: {$result['status']}\n";
    echo "   - Focos detectados: {$result['count']}\n";
    echo "   - Caché: " . ($result['cached'] ? 'Sí' : 'No') . "\n";
    echo "\n";
    
    if ($result['count'] > 0) {
        echo "🔥 Primeros 5 focos de calor:\n";
        echo "   ┌────────────┬─────────────┬──────────────────┬────────────┐\n";
        echo "   │  Latitud   │  Longitud   │      Fecha       │ Confianza  │\n";
        echo "   ├────────────┼─────────────┼──────────────────┼────────────┤\n";
        
        $fires = array_slice($result['data'], 0, 5);
        foreach ($fires as $fire) {
            $lat = str_pad(number_format($fire['lat'], 4), 10, ' ', STR_PAD_LEFT);
            $lng = str_pad(number_format($fire['lng'], 4), 11, ' ', STR_PAD_LEFT);
            $date = str_pad($fire['date'] ?? 'N/A', 16, ' ', STR_PAD_LEFT);
            $conf = str_pad($fire['confidence'] ?? 'N/A', 10, ' ', STR_PAD_LEFT);
            echo "   │ {$lat} │ {$lng} │ {$date} │ {$conf} │\n";
        }
        
        echo "   └────────────┴─────────────┴──────────────────┴────────────┘\n";
        
        if ($result['count'] > 5) {
            $remaining = $result['count'] - 5;
            echo "   ... y {$remaining} focos más\n";
        }
    } else {
        echo "ℹ️  No se detectaron focos de calor en las últimas 24 horas.\n";
        echo "   Esto puede ser normal si no hay incendios activos.\n";
    }
    
    echo "\n";
    echo "✨ El servicio está funcionando correctamente!\n";
    
} else {
    echo "❌ Error en la conexión\n";
    echo "\n";
    echo "📝 Detalles del error:\n";
    echo "   - Status: {$result['status']}\n";
    echo "   - Mensaje: {$result['error']}\n";
    echo "\n";
    
    if ($result['status'] === 401) {
        echo "💡 Solución:\n";
        echo "   1. Obtén una API Key gratis en:\n";
        echo "      https://firms.modaps.eosdis.nasa.gov/api/area/\n";
        echo "   2. Agrégala a tu archivo .env:\n";
        echo "      FIRMS_API_KEY=tu_clave_aqui\n";
        echo "\n";
    }
}

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "\n";
