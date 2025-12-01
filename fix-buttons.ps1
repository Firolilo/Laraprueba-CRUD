# Script para corregir todos los componentes AdminLTE button con href
# Reemplaza <x-adminlte-button> con href por <a> tags

$basePath = "C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD\resources\views"

# Patrón 1: Botones Volver (secondary)
$pattern1 = '<x-adminlte-button label="Volver" icon="fas fa-arrow-left" \s*class="btn-sm" theme="secondary" href="{{ route\(''([^'']+)''\) }}"/>'
$replace1 = '<a href="{{ route(''$1'') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Volver</a>'

# Patrón 2: Botones Editar (warning/success)
$pattern2 = '<x-adminlte-button label="Editar" icon="fas fa-edit" \s*class="btn-sm" theme="(warning|success)" href="{{ route\(''([^'']+)'', \$([^)]+)\) }}"/>'
$replace2 = '<a href="{{ route(''$2'', $$3) }}" class="btn btn-$1 btn-sm"><i class="fas fa-edit"></i> Editar</a>'

# Patrón 3: Botones Cancelar en forms
$pattern3 = '<x-adminlte-button label="Cancelar" theme="secondary" icon="fas fa-(arrow-left|times)" \s*(class="[^"]*")?\s*href="{{ route\(''([^'']+)''\) }}"/>'
$replace3 = '<a href="{{ route(''$3'') }}" class="btn btn-secondary $2"><i class="fas fa-$1"></i> Cancelar</a>'

Write-Host "Corrigiendo archivos en: $basePath" -ForegroundColor Green

Get-ChildItem -Path $basePath -Filter "*.blade.php" -Recurse | ForEach-Object {
    $file = $_.FullName
    $content = Get-Content $file -Raw -Encoding UTF8
    $modified = $false
    
    # Aplicar patrón 1
    if ($content -match $pattern1) {
        $content = $content -replace $pattern1, $replace1
        $modified = $true
        Write-Host "  - Pattern 1 applied to: $($_.Name)" -ForegroundColor Yellow
    }
    
    # Aplicar patrón 2
    if ($content -match $pattern2) {
        $content = $content -replace $pattern2, $replace2
        $modified = $true
        Write-Host "  - Pattern 2 applied to: $($_.Name)" -ForegroundColor Yellow
    }
    
    # Aplicar patrón 3
    if ($content -match $pattern3) {
        $content = $content -replace $pattern3, $replace3
        $modified = $true
        Write-Host "  - Pattern 3 applied to: $($_.Name)" -ForegroundColor Yellow
    }
    
    if ($modified) {
        Set-Content -Path $file -Value $content -Encoding UTF8 -NoNewline
        Write-Host "✅ Modificado: $($_.Name)" -ForegroundColor Green
    }
}

Write-Host "`n✅ Proceso completado!" -ForegroundColor Green
