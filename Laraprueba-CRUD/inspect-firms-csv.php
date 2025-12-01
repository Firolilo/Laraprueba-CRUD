#!/usr/bin/env php
<?php
/**
 * Script para inspeccionar el formato CSV de FIRMS
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = config('services.firms.key');

if (!$apiKey) {
    echo "❌ No se encontró FIRMS_API_KEY en .env\n";
    exit(1);
}

echo "\n";
echo "🔍 Inspeccionando formato CSV de NASA FIRMS\n";
echo "═══════════════════════════════════════════════\n\n";

$url = sprintf(
    'https://firms.modaps.eosdis.nasa.gov/api/area/csv/%s/VIIRS_NOAA20_NRT/-62.5,-18.5,-57.5,-14.5/3',
    $apiKey
);

echo "📡 Consultando API...\n";
$response = Http::timeout(20)->get($url);

if (!$response->ok()) {
    echo "❌ Error: " . $response->status() . "\n";
    exit(1);
}

$csv = $response->body();
$lines = explode("\n", trim($csv));

echo "✅ Respuesta recibida\n\n";

// Mostrar header
echo "📋 HEADER (columnas):\n";
echo "─────────────────────────────────────────────\n";
$headers = str_getcsv($lines[0]);
foreach ($headers as $index => $header) {
    echo sprintf("[%2d] %s\n", $index, $header);
}

echo "\n";
echo "📊 PRIMERAS 3 FILAS DE DATOS:\n";
echo "─────────────────────────────────────────────\n";

for ($i = 1; $i <= min(3, count($lines) - 1); $i++) {
    if (empty(trim($lines[$i]))) continue;
    
    echo "\nFila {$i}:\n";
    $data = str_getcsv($lines[$i]);
    
    foreach ($data as $index => $value) {
        $header = $headers[$index] ?? "Unknown";
        echo sprintf("  [%2d] %-20s = %s\n", $index, $header, $value);
    }
}

echo "\n";
echo "═══════════════════════════════════════════════\n";
echo "\n";
