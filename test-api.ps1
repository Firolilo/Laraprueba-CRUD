# 🧪 Test API - Script de Prueba

# Configuración
$API_URL = "http://localhost:8000/api"
$EMAIL = "test@example.com"
$PASSWORD = "password123"

Write-Host "🔥 Testing Fire Prediction API..." -ForegroundColor Cyan
Write-Host ""

# 1. Registro de usuario
Write-Host "1️⃣  Registrando nuevo usuario..." -ForegroundColor Yellow
$registerBody = @{
    name = "Usuario Test"
    email = $EMAIL
    password = $PASSWORD
    password_confirmation = $PASSWORD
    telefono = "12345678"
} | ConvertTo-Json

try {
    $registerResponse = Invoke-RestMethod -Uri "$API_URL/register" -Method Post -Body $registerBody -ContentType "application/json"
    $TOKEN = $registerResponse.token
    Write-Host "✅ Usuario registrado exitosamente!" -ForegroundColor Green
    Write-Host "Token: $TOKEN" -ForegroundColor Gray
    Write-Host ""
} catch {
    Write-Host "⚠️  Usuario ya existe, intentando login..." -ForegroundColor Yellow
    
    # 2. Login si el usuario ya existe
    $loginBody = @{
        email = $EMAIL
        password = $PASSWORD
    } | ConvertTo-Json
    
    $loginResponse = Invoke-RestMethod -Uri "$API_URL/login" -Method Post -Body $loginBody -ContentType "application/json"
    $TOKEN = $loginResponse.token
    Write-Host "✅ Login exitoso!" -ForegroundColor Green
    Write-Host "Token: $TOKEN" -ForegroundColor Gray
    Write-Host ""
}

# Headers con autenticación
$headers = @{
    "Authorization" = "Bearer $TOKEN"
    "Accept" = "application/json"
    "Content-Type" = "application/json"
}

# 3. Obtener tipos de biomasa públicos
Write-Host "2️⃣  Obteniendo tipos de biomasa (público)..." -ForegroundColor Yellow
try {
    $tipos = Invoke-RestMethod -Uri "$API_URL/public/tipos-biomasa" -Method Get
    Write-Host "✅ Encontrados $($tipos.data.Count) tipos de biomasa" -ForegroundColor Green
    $tipos.data | ForEach-Object {
        Write-Host "   - $($_.tipo_biomasa) (Modificador: $($_.modificador_intensidad)x, Color: $($_.color))" -ForegroundColor Gray
    }
    Write-Host ""
} catch {
    Write-Host "❌ Error al obtener tipos de biomasa" -ForegroundColor Red
}

# 4. Obtener focos de incendio
Write-Host "3️⃣  Obteniendo focos de incendio..." -ForegroundColor Yellow
try {
    $focos = Invoke-RestMethod -Uri "$API_URL/focos-incendios" -Headers $headers -Method Get
    Write-Host "✅ Encontrados $($focos.data.Count) focos de incendio" -ForegroundColor Green
    $focos.data | Select-Object -First 3 | ForEach-Object {
        Write-Host "   - $($_.ubicacion) (Intensidad: $($_.intensidad))" -ForegroundColor Gray
    }
    Write-Host ""
} catch {
    Write-Host "❌ Error al obtener focos" -ForegroundColor Red
}

# 5. Crear un nuevo foco de incendio
Write-Host "4️⃣  Creando nuevo foco de incendio..." -ForegroundColor Yellow
$newFoco = @{
    fecha = (Get-Date).ToString("yyyy-MM-ddTHH:mm:ss")
    ubicacion = "Test API - Zona Norte"
    coordenadas = @(-17.80, -61.50)
    intensidad = 6.5
} | ConvertTo-Json

try {
    $createdFoco = Invoke-RestMethod -Uri "$API_URL/focos-incendios" -Headers $headers -Method Post -Body $newFoco
    Write-Host "✅ Foco creado con ID: $($createdFoco.data.id)" -ForegroundColor Green
    Write-Host "   Ubicación: $($createdFoco.data.ubicacion)" -ForegroundColor Gray
    Write-Host ""
    
    $FOCO_ID = $createdFoco.data.id
} catch {
    Write-Host "❌ Error al crear foco: $_" -ForegroundColor Red
}

# 6. Obtener biomasas
Write-Host "5️⃣  Obteniendo biomasas..." -ForegroundColor Yellow
try {
    $biomasas = Invoke-RestMethod -Uri "$API_URL/biomasas" -Headers $headers -Method Get
    Write-Host "✅ Encontradas $($biomasas.data.Count) biomasas" -ForegroundColor Green
    $biomasas.data | Select-Object -First 3 | ForEach-Object {
        Write-Host "   - Tipo: $($_.tipo_biomasa.tipo_biomasa), Área: $($_.area_m2) m²" -ForegroundColor Gray
    }
    Write-Host ""
} catch {
    Write-Host "❌ Error al obtener biomasas" -ForegroundColor Red
}

# 7. Obtener predicciones
Write-Host "6️⃣  Obteniendo predicciones..." -ForegroundColor Yellow
try {
    $predictions = Invoke-RestMethod -Uri "$API_URL/predictions" -Headers $headers -Method Get
    Write-Host "✅ Encontradas $($predictions.data.Count) predicciones" -ForegroundColor Green
    Write-Host ""
} catch {
    Write-Host "❌ Error al obtener predicciones" -ForegroundColor Red
}

# 8. Obtener usuario actual
Write-Host "7️⃣  Verificando usuario autenticado..." -ForegroundColor Yellow
try {
    $user = Invoke-RestMethod -Uri "$API_URL/user" -Headers $headers -Method Get
    Write-Host "✅ Usuario: $($user.name) ($($user.email))" -ForegroundColor Green
    Write-Host ""
} catch {
    Write-Host "❌ Error al verificar usuario" -ForegroundColor Red
}

# Resumen
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
Write-Host "✨ Test completado!" -ForegroundColor Green
Write-Host ""
Write-Host "📋 Endpoints disponibles:" -ForegroundColor Cyan
Write-Host "   POST   /api/register" -ForegroundColor Gray
Write-Host "   POST   /api/login" -ForegroundColor Gray
Write-Host "   POST   /api/logout" -ForegroundColor Gray
Write-Host "   GET    /api/user" -ForegroundColor Gray
Write-Host "   CRUD   /api/focos-incendios" -ForegroundColor Gray
Write-Host "   CRUD   /api/biomasas" -ForegroundColor Gray
Write-Host "   CRUD   /api/tipos-biomasa" -ForegroundColor Gray
Write-Host "   CRUD   /api/predictions" -ForegroundColor Gray
Write-Host "   CRUD   /api/simulaciones" -ForegroundColor Gray
Write-Host ""
Write-Host "🔑 Token guardado para próximas peticiones" -ForegroundColor Cyan
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
