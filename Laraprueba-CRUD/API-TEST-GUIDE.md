# 🧪 Guía de Pruebas de API - SIPII Consolidada

## 🚀 Inicio Rápido

### 1. Iniciar el Servidor

```bash
cd "C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD"
php artisan serve --port=8000
```

O simplemente doble clic en **`INICIAR-SIPII.bat`** en la carpeta raíz.

---

## 🔐 Pruebas de Autenticación

### Registro de Usuario

```powershell
# PowerShell
$body = @{
    name = "Juan Pérez"
    email = "juan@example.com"
    password = "password123"
    password_confirmation = "password123"
    telefono = "12345678"
    cedula_identidad = "1234567"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/register" `
    -Method POST `
    -ContentType "application/json" `
    -Body $body
```

**Respuesta esperada:**
```json
{
  "message": "Usuario registrado exitosamente",
  "user": {
    "id": 1,
    "name": "Juan Pérez",
    "email": "juan@example.com"
  },
  "token": "1|abc123..."
}
```

**⚠️ IMPORTANTE:** Guarda el token devuelto, lo necesitarás para las siguientes peticiones.

---

### Login

```powershell
# PowerShell
$body = @{
    email = "juan@example.com"
    password = "password123"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/login" `
    -Method POST `
    -ContentType "application/json" `
    -Body $body
```

**Respuesta esperada:**
```json
{
  "message": "Inicio de sesión exitoso",
  "user": {
    "id": 1,
    "name": "Juan Pérez",
    "email": "juan@example.com"
  },
  "role": "voluntario",
  "is_admin": false,
  "is_volunteer": true,
  "token": "2|xyz789..."
}
```

---

### Logout

```powershell
# PowerShell (reemplaza {TOKEN} con tu token real)
$headers = @{
    "Authorization" = "Bearer {TOKEN}"
}

Invoke-RestMethod -Uri "http://localhost:8000/api/logout" `
    -Method POST `
    -Headers $headers
```

---

## 🌦️ Endpoints Externos (Sin Autenticación)

### Clima (Open-Meteo)

```powershell
# Clima actual
Invoke-RestMethod -Uri "http://localhost:8000/api/weather?latitude=-17.8&longitude=-63.1"

# Clima histórico
Invoke-RestMethod -Uri "http://localhost:8000/api/weather?latitude=-17.8&longitude=-63.1&start_date=2025-01-01&end_date=2025-01-07"
```

### Focos de Calor (FIRMS)

```powershell
# Focos en Bolivia últimas 24h
Invoke-RestMethod -Uri "http://localhost:8000/api/fires?country=BOL&days=1"

# Focos con producto específico
Invoke-RestMethod -Uri "http://localhost:8000/api/fires?product=VIIRS_NOAA20_NRT&country=BOL&days=3"
```

---

## 🌳 Endpoints Públicos (Sin Autenticación)

### Listar Biomasas Públicas

```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/public/biomasas"
```

### Listar Focos de Incendio Públicos

```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/public/focos-incendios"
```

### Listar Tipos de Biomasa Públicos

```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/public/tipos-biomasa"
```

---

## 🔒 Endpoints Protegidos (Requieren Token)

**IMPORTANTE:** Reemplaza `{TOKEN}` con el token obtenido en login/registro.

### Biomasas - CRUD Completo

```powershell
# Listar todas las biomasas
$headers = @{ "Authorization" = "Bearer {TOKEN}" }
Invoke-RestMethod -Uri "http://localhost:8000/api/biomasas" -Headers $headers

# Crear nueva biomasa
$body = @{
    tipo_biomasa_id = 1
    ubicacion = "Sabana de Santa Cruz"
    coordenadas = @(
        @{ lat = -17.8; lng = -63.1 },
        @{ lat = -17.9; lng = -63.1 },
        @{ lat = -17.9; lng = -63.2 },
        @{ lat = -17.8; lng = -63.2 }
    )
    area_m2 = 1000000
    densidad = "media"
    descripcion = "Área de pastizales con densidad media"
} | ConvertTo-Json -Depth 10

Invoke-RestMethod -Uri "http://localhost:8000/api/biomasas" `
    -Method POST `
    -ContentType "application/json" `
    -Headers $headers `
    -Body $body

# Ver biomasa específica
Invoke-RestMethod -Uri "http://localhost:8000/api/biomasas/1" -Headers $headers

# Actualizar biomasa
$body = @{
    densidad = "alta"
    descripcion = "Actualizada a densidad alta"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/biomasas/1" `
    -Method PUT `
    -ContentType "application/json" `
    -Headers $headers `
    -Body $body

# Eliminar biomasa
Invoke-RestMethod -Uri "http://localhost:8000/api/biomasas/1" `
    -Method DELETE `
    -Headers $headers
```

---

### Focos de Incendio - CRUD Completo

```powershell
$headers = @{ "Authorization" = "Bearer {TOKEN}" }

# Listar todos
Invoke-RestMethod -Uri "http://localhost:8000/api/focos-incendios" -Headers $headers

# Crear nuevo foco
$body = @{
    fecha = "2025-01-30"
    ubicacion = "Santa Cruz, Bolivia"
    coordenadas = @{ lat = -17.783; lng = -63.182 }
    intensidad = 7.5
    estado = "activo"
} | ConvertTo-Json -Depth 10

Invoke-RestMethod -Uri "http://localhost:8000/api/focos-incendios" `
    -Method POST `
    -ContentType "application/json" `
    -Headers $headers `
    -Body $body

# Ver foco específico
Invoke-RestMethod -Uri "http://localhost:8000/api/focos-incendios/1" -Headers $headers

# Actualizar estado
$body = @{
    estado = "controlado"
    intensidad = 3.0
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/focos-incendios/1" `
    -Method PUT `
    -ContentType "application/json" `
    -Headers $headers `
    -Body $body

# Eliminar foco
Invoke-RestMethod -Uri "http://localhost:8000/api/focos-incendios/1" `
    -Method DELETE `
    -Headers $headers
```

---

### Predicciones - CRUD Completo

```powershell
$headers = @{ "Authorization" = "Bearer {TOKEN}" }

# Listar todas
Invoke-RestMethod -Uri "http://localhost:8000/api/predictions" -Headers $headers

# Crear predicción
$body = @{
    foco_incendio_id = 1
    predicted_at = "2025-01-31T12:00:00Z"
    path = @(
        @{ lat = -17.783; lng = -63.182; timestamp = "2025-01-31T12:00:00Z" },
        @{ lat = -17.785; lng = -63.185; timestamp = "2025-01-31T13:00:00Z" }
    )
    meta = @{
        confidence = 0.85
        model_version = "v1.0"
        wind_direction = "NE"
    }
} | ConvertTo-Json -Depth 10

Invoke-RestMethod -Uri "http://localhost:8000/api/predictions" `
    -Method POST `
    -ContentType "application/json" `
    -Headers $headers `
    -Body $body
```

---

## 👑 Endpoints Solo Administradores

**IMPORTANTE:** Estos endpoints requieren que el usuario autenticado tenga rol de **Administrador**.

### Tipos de Biomasa - CRUD (Admin Only)

```powershell
$headers = @{ "Authorization" = "Bearer {TOKEN_ADMIN}" }

# Listar todos
Invoke-RestMethod -Uri "http://localhost:8000/api/tipos-biomasa" -Headers $headers

# Crear nuevo tipo
$body = @{
    tipo_biomasa = "Bosque Seco Tropical"
    color = "#228B22"
    modificador_intensidad = 2.5
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/tipos-biomasa" `
    -Method POST `
    -ContentType "application/json" `
    -Headers $headers `
    -Body $body

# Ver tipo específico
Invoke-RestMethod -Uri "http://localhost:8000/api/tipos-biomasa/1" -Headers $headers

# Actualizar tipo
$body = @{
    modificador_intensidad = 3.0
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/tipos-biomasa/1" `
    -Method PUT `
    -ContentType "application/json" `
    -Headers $headers `
    -Body $body

# Eliminar tipo
Invoke-RestMethod -Uri "http://localhost:8000/api/tipos-biomasa/1" `
    -Method DELETE `
    -Headers $headers
```

---

### Simulaciones (Admin Only)

```powershell
$headers = @{ "Authorization" = "Bearer {TOKEN_ADMIN}" }

# Listar todas
Invoke-RestMethod -Uri "http://localhost:8000/api/simulaciones" -Headers $headers

# Crear simulación
$body = @{
    nombre = "Simulación Santa Cruz 2025"
    parameters = @{
        wind_speed = 15
        wind_direction = "NE"
        temperature = 35
        humidity = 20
    }
    initial_fires = @(
        @{ lat = -17.783; lng = -63.182; intensity = 8.0 }
    )
    history = @()
} | ConvertTo-Json -Depth 10

Invoke-RestMethod -Uri "http://localhost:8000/api/simulaciones" `
    -Method POST `
    -ContentType "application/json" `
    -Headers $headers `
    -Body $body

# Ver simulación específica
Invoke-RestMethod -Uri "http://localhost:8000/api/simulaciones/1" -Headers $headers

# Eliminar simulación
Invoke-RestMethod -Uri "http://localhost:8000/api/simulaciones/1" `
    -Method DELETE `
    -Headers $headers
```

---

## 📊 Códigos de Respuesta HTTP

| Código | Significado |
|--------|-------------|
| 200 | OK - Petición exitosa |
| 201 | Created - Recurso creado exitosamente |
| 401 | Unauthorized - Token inválido o ausente |
| 403 | Forbidden - No tienes permisos (requiere rol admin) |
| 404 | Not Found - Recurso no encontrado |
| 422 | Unprocessable Entity - Errores de validación |
| 500 | Internal Server Error - Error del servidor |

---

## 🔧 Troubleshooting

### Error: "Unauthenticated"
- Verifica que incluyes el header `Authorization: Bearer {TOKEN}`
- Verifica que el token es válido (no ha expirado)
- Prueba hacer login nuevamente

### Error: "Forbidden" o "No tienes permisos"
- Este endpoint requiere rol de administrador
- Verifica tu rol con el endpoint `/api/login` (campo `role`)
- Contacta a un administrador para cambiar tu rol

### Error: "Route [login] not defined"
- Asegúrate de estar usando `/api/login` en vez de `/login`
- El servidor debe estar corriendo en puerto 8000

### Error de conexión
- Verifica que el servidor esté corriendo: `php artisan serve --port=8000`
- Verifica que estás usando `http://localhost:8000` y no otro puerto

---

## 📱 Integración con Flutter

### Configuración Base

```dart
// lib/config/api_config.dart
class ApiConfig {
  static const String baseUrl = 'http://TU_IP:8000/api';
  static const String tokenKey = 'auth_token';
}
```

### Ejemplo de Servicio de Autenticación

```dart
// lib/services/auth_service.dart
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';

class AuthService {
  static Future<Map<String, dynamic>> register({
    required String name,
    required String email,
    required String password,
    String? telefono,
    String? cedulaIdentidad,
  }) async {
    final response = await http.post(
      Uri.parse('${ApiConfig.baseUrl}/register'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({
        'name': name,
        'email': email,
        'password': password,
        'password_confirmation': password,
        'telefono': telefono,
        'cedula_identidad': cedulaIdentidad,
      }),
    );

    if (response.statusCode == 201) {
      final data = jsonDecode(response.body);
      await _saveToken(data['token']);
      return data;
    } else {
      throw Exception('Error en registro');
    }
  }

  static Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('${ApiConfig.baseUrl}/login'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({'email': email, 'password': password}),
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      await _saveToken(data['token']);
      return data;
    } else {
      throw Exception('Credenciales inválidas');
    }
  }

  static Future<void> _saveToken(String token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString(ApiConfig.tokenKey, token);
  }

  static Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString(ApiConfig.tokenKey);
  }

  static Future<void> logout() async {
    final token = await getToken();
    if (token != null) {
      await http.post(
        Uri.parse('${ApiConfig.baseUrl}/logout'),
        headers: {'Authorization': 'Bearer $token'},
      );
    }
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove(ApiConfig.tokenKey);
  }
}
```

### Ejemplo de Petición Protegida

```dart
// lib/services/biomasa_service.dart
class BiomasaService {
  static Future<List<Biomasa>> getBiomasas() async {
    final token = await AuthService.getToken();
    final response = await http.get(
      Uri.parse('${ApiConfig.baseUrl}/biomasas'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      return (data['data'] as List)
          .map((json) => Biomasa.fromJson(json))
          .toList();
    } else {
      throw Exception('Error al cargar biomasas');
    }
  }
}
```

---

## ✅ Checklist de Integración

- [ ] Servidor Laravel corriendo en puerto 8000
- [ ] Base de datos PostgreSQL conectada
- [ ] Migraciones ejecutadas (`php artisan migrate`)
- [ ] Al menos un usuario registrado
- [ ] Token obtenido mediante `/api/login`
- [ ] Endpoints públicos funcionando sin token
- [ ] Endpoints protegidos funcionando con token
- [ ] Roles configurados correctamente (admin/voluntario)
- [ ] App Flutter configurada con IP correcta
- [ ] Dependencias instaladas en Flutter (`http`, `shared_preferences`)

---

## 🎉 ¡Listo!

Tu API REST consolidada está funcionando correctamente. Ahora puedes:

1. ✅ Usar el panel web en `http://localhost:8000`
2. ✅ Conectar la app Flutter a `http://TU_IP:8000/api`
3. ✅ Autenticar usuarios con Sanctum
4. ✅ Realizar operaciones CRUD completas
5. ✅ Obtener datos de clima y focos de calor
6. ✅ Gestionar biomasas, simulaciones y predicciones

**Recuerda:** Todo está unificado en un solo servidor. No necesitas iniciar `sipii-api` separado.
