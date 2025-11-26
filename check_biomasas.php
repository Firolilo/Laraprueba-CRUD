<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$biomasas = App\Models\Biomasa::with('tipoBiomasa')->whereNotNull('coordenadas')->get();

echo "Total biomasas: " . App\Models\Biomasa::count() . "\n";
echo "Biomasas con coordenadas: " . $biomasas->count() . "\n\n";

if ($biomasas->isEmpty()) {
    echo "No hay biomasas con coordenadas.\n";
    
    $all = App\Models\Biomasa::all();
    echo "Todas las biomasas:\n";
    foreach ($all as $b) {
        echo "ID: {$b->id}, Coordenadas: " . ($b->coordenadas ? 'SI' : 'NO') . "\n";
        if ($b->coordenadas) {
            echo "  Valor: " . json_encode($b->coordenadas) . "\n";
        }
    }
} else {
    foreach ($biomasas as $biomasa) {
        echo "ID: {$biomasa->id}\n";
        echo "Tipo: " . ($biomasa->tipoBiomasa ? $biomasa->tipoBiomasa->tipo_biomasa : 'NULL') . "\n";
        echo "Color: " . ($biomasa->tipoBiomasa ? $biomasa->tipoBiomasa->color : 'NULL') . "\n";
        echo "Coordenadas tipo: " . gettype($biomasa->coordenadas) . "\n";
        echo "Coordenadas: " . json_encode($biomasa->coordenadas) . "\n";
        echo "---\n";
    }
}
