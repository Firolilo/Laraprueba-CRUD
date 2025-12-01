# ✅ SIPII - Sistema Unificado de Monitoreo de Incendios

## 🎉 Panel Web con API REST Completa Integrada

### 📁 Estructura Consolidada

```
Laraprueba-CRUD/
├── Laraprueba-CRUD/          # ⭐ Aplicación Unificada (Puerto 8000)
│   ├── routes/
│   │   ├── web.php           # Panel web (Dashboard, CRUDs, Auth sesiones)
│   │   └── api.php           # 🔥 API REST completa con Sanctum
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Api/
│   │   │   │   │   ├── AuthController.php         # Login/Register/Logout
│   │   │   │   │   ├── BiomasaController.php      # CRUD biomasas
│   │   │   │   │   ├── FocosIncendioController.php # CRUD focos
│   │   │   │   │   ├── TipoBiomasaController.php  # CRUD tipos
│   │   │   │   │   ├── SimulacionController.php   # CRUD simulaciones
│   │   │   │   │   ├── PredictionController.php   # CRUD predicciones
│   │   │   │   │   ├── WeatherController.php      # Open-Meteo
│   │   │   │   │   └── FiresController.php        # NASA FIRMS
│   │   │   │   └── DashboardController.php        # Dashboard web
│   │   │   ├── Resources/                         # 🎨 API Resources (JSON)
│   │   │   │   ├── BiomasaResource.php
│   │   │   │   ├── FocosIncendioResource.php
│   │   │   │   ├── TipoBiomasaResource.php
│   │   │   │   ├── SimulacioneResource.php
│   │   │   │   └── PredictionResource.php
│   │   │   └── Middleware/
│   │   │       └── CheckRole.php                  # Middleware role:administrador
│   │   ├── Services/
│   │   │   ├── OpenMeteoService.php               # Clima actual/histórico
│   │   │   ├── FirmsDataService.php               # Focos de calor NASA
│   │   │   └── WeatherService.php                 # OpenWeatherMap (legacy)
│   │   └── Models/
│   │       ├── User.php                           # getRoleType(), isAdministrador()
│   │       ├── Biomasa.php
│   │       ├── FocosIncendio.php
│   │       ├── TipoBiomasa.php
│   │       ├── Simulacione.php
│   │       └── Prediction.php
│   └── resources/views/
│       ├── dashboard.blade.php                    # Mapa Leaflet interactivo
│       └── layouts/app.blade.php                  # AdminLTE + Leaflet
├── sipii-api/                 # ⚠️ OBSOLETO - Solo referencia histórica
├── sipii_flutter/             # App móvil Flutter (conecta a :8000/api)
├── INICIAR-SIPII.bat          # Script para iniciar servidor unificado
└── LEEME-ESTRUCTURA.md        # 📖 Este archivo
```

---

## 🚀 Iniciar el Sistema

### Opción 1: Script Automático (Recomendado)
Doble clic en: **`INICIAR-SIPII.bat`** → Iniciará panel web unificado en puerto 8000

### Opción 2: Manual

**Terminal - Panel Web Unificado:**
```bash
cd "C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD"
php artisan serve --port=8000
```

---

## 🌐 Aplicación Unificada - Todo en Puerto 8000

### Panel Web + API REST Completa (Puerto 8000)
- **Panel Web:** http://localhost:8000
- **API REST:** http://localhost:8000/api
- **Características:**
  - ✅ Dashboard con mapa Leaflet interactivo
  - ✅ Focos de calor desde FIRMS (NASA)
  - ✅ Áreas de biomasa con polígonos
  - ✅ Clima actual desde Open-Meteo
  - ✅ CRUD completo de biomasas, focos, tipos
  - ✅ Simulador de incendios
  - ✅ Predicciones de propagación
  - ✅ Gestión de usuarios (Administradores/Voluntarios)
  - ✅ **API REST con autenticación Sanctum**
  - ✅ **Endpoints públicos y protegidos**
  - ✅ **Autorización basada en roles**

### App Móvil Flutter
- **Conexión:** http://192.168.0.TU_IP:8000/api
- **Autenticación:** Bearer token (Sanctum)
- **Funcionalidades:**
  - ✅ Login/Registro
  - ✅ Mapa con focos de incendio
  - ✅ Polígonos de biomasas
  - ✅ CRUD de biomasas
  - ✅ Compartir por WhatsApp

---

## 📊 Base de Datos

- Base de datos: `cruds`
- Usuario: `laravel`
- Password: `laravel`
- Puerto: `5432`
- Tipo: PostgreSQL

---

## 📝 Endpoints API Completos

### 🔐 Autenticación (Sanctum)

#### Registro
```
POST http://localhost:8000/api/register
Content-Type: application/json

{
  "name": "Juan Pérez",
  "email": "juan@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "telefono": "12345678",
  "cedula_identidad": "1234567"
}
```

**Respuesta:**
```json
{
  "message": "Usuario registrado exitosamente",
  "user": { "id": 1, "name": "Juan Pérez", "email": "juan@example.com" },
  "token": "1|abc123..."
}
```

#### Login
```
POST http://localhost:8000/api/login
Content-Type: application/json

{
  "email": "juan@example.com",
  "password": "password123"
}
```

**Respuesta:**
```json
{
  "message": "Inicio de sesión exitoso",
  "user": { "id": 1, "name": "Juan Pérez", "email": "juan@example.com" },
  "role": "voluntario",
  "is_admin": false,
  "is_volunteer": true,
  "token": "2|xyz789..."
}
```

#### Logout
```
POST http://localhost:8000/api/logout
Authorization: Bearer {token}
```

---

### 🌦️ Clima (Open-Meteo)
```
GET http://localhost:8000/api/weather?latitude={lat}&longitude={lon}
GET http://localhost:8000/api/weather?latitude={lat}&longitude={lon}&start_date=YYYY-MM-DD&end_date=YYYY-MM-DD
```

**Respuesta:**
```json
{
  "ok": true,
  "status": 200,
  "data": {
    "current_weather": { "temperature": 31.6, ... },
    "hourly": { "temperature_2m": [...], "relative_humidity_2m": [...] }
  },
  "cached": false
}
```

---

### 🔥 Focos de Calor (NASA FIRMS)
```
GET http://localhost:8000/api/fires
GET http://localhost:8000/api/fires?product=VIIRS_NOAA20_NRT&country=BOL&days=3
```

**Parámetros:**
- `product`: VIIRS_SNPP_NRT, VIIRS_NOAA20_NRT, MODIS_NRT, etc.
- `country`: ISO3 (BOL, ARG, BRA, etc.)
- `days`: 1-10

**Respuesta:**
```json
{
  "ok": true,
  "status": 200,
  "data": [
    {
      "lat": -17.123,
      "lng": -63.456,
      "date": "2025-11-30",
      "confidence": "high"
    }
  ],
  "count": 1,
  "cached": false
}
```

---

### 🌳 Endpoints Públicos (sin autenticación)

```
GET http://localhost:8000/api/public/focos-incendios
GET http://localhost:8000/api/public/biomasas
GET http://localhost:8000/api/public/tipos-biomasa
```

---

### 🔒 Endpoints Protegidos (requieren token)

#### Biomasas (CRUD completo)
```
GET    /api/biomasas               → Listar todas
POST   /api/biomasas               → Crear nueva
GET    /api/biomasas/{id}          → Ver detalle
PUT    /api/biomasas/{id}          → Actualizar
DELETE /api/biomasas/{id}          → Eliminar
```

#### Focos de Incendio (CRUD completo)
```
GET    /api/focos-incendios        → Listar todos
POST   /api/focos-incendios        → Crear nuevo
GET    /api/focos-incendios/{id}   → Ver detalle
PUT    /api/focos-incendios/{id}   → Actualizar
DELETE /api/focos-incendios/{id}   → Eliminar
```

#### Predicciones (CRUD completo)
```
GET    /api/predictions            → Listar todas
POST   /api/predictions            → Crear nueva
GET    /api/predictions/{id}       → Ver detalle
PUT    /api/predictions/{id}       → Actualizar
DELETE /api/predictions/{id}       → Eliminar
```

---

### 👑 Endpoints Solo Administradores

#### Tipos de Biomasa (CRUD completo)
```
GET    /api/tipos-biomasa          → Listar todos
POST   /api/tipos-biomasa          → Crear nuevo
GET    /api/tipos-biomasa/{id}     → Ver detalle
PUT    /api/tipos-biomasa/{id}     → Actualizar
DELETE /api/tipos-biomasa/{id}     → Eliminar
```

#### Simulaciones
```
GET    /api/simulaciones           → Listar todas
POST   /api/simulaciones           → Crear nueva
GET    /api/simulaciones/{id}      → Ver detalle
DELETE /api/simulaciones/{id}      → Eliminar
```

---

### 🗺️ Biomasas para Mapa (Web Dashboard)
```
GET http://localhost:8000/dashboard/biomasas
```

**Respuesta (GeoJSON):**
```json
{
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "type": "Polygon",
        "coordinates": [[[-63.1, -17.8], ...]]
      },
      "properties": {
        "ubicacion": "Sabana",
        "area": "4599.08 km²",
        "densidad": "Media",
        "tipo": "Pastizal",
        "fecha": "10/10/2025"
      }
    }
  ]
}
```

---

## 🎯 Rutas del Panel Web

### Autenticación
```
GET  /login
POST /login
POST /logout
GET  /register
POST /register
```

### Dashboard
```
GET / → Dashboard con mapa, clima y estadísticas
```

### Biomasas (Voluntarios + Admins)
```
GET    /biomasas
GET    /biomasas/create
POST   /biomasas
GET    /biomasas/{id}
GET    /biomasas/{id}/edit
PUT    /biomasas/{id}
DELETE /biomasas/{id}
```

### Administración (Solo Admins)
```
/users                 → Gestión de usuarios
/tipo-biomasas         → Catálogo de tipos
/administradores       → Gestión de administradores
/voluntarios           → Gestión de voluntarios
/simulaciones          → Simulaciones guardadas
/focos-incendios       → Focos de incendio
/predictions           → Predicciones
```

---

## ⚠️ Arquitectura Consolidada - Un Solo Servidor

### ✅ Arquitectura Actual (CONSOLIDADA):
- **Puerto 8000**: Panel web + API REST completa
- **sipii-api**: Carpeta obsoleta (mantener como referencia histórica)
- **Todo unificado**: Autenticación, CRUD, datos externos, dashboard web

### ✅ Hacer:
- Usar **puerto 8000** para panel web y API
- Acceder al dashboard en http://localhost:8000
- Usar `/api/login`, `/api/register` para autenticación desde Flutter
- Usar `/api/biomasas`, `/api/focos-incendios`, etc. para CRUD
- Usar `/api/weather` y `/api/fires` para clima y focos
- Incluir `Authorization: Bearer {token}` en requests protegidos

### ❌ NO Hacer:
- NO necesitas iniciar sipii-api (puerto 8001)
- NO hay separación entre panel y API
- sipii-api existe solo como archivo histórico (NO USAR)

---

## 🔧 Comandos Útiles

```bash
cd Laraprueba-CRUD

# Limpiar cachés
php artisan optimize:clear

# Ver todas las rutas
php artisan route:list

# Ver rutas API
php artisan route:list --path=api

# Ver rutas protegidas
php artisan route:list --path=api | findstr "sanctum"

# Iniciar servidor
php artisan serve --port=8000
```

---

## 📱 Configurar App Flutter

Para conectar Flutter al backend unificado:

```dart
// lib/services/api_service.dart
static const String baseUrl = 'http://TU_IP_LOCAL:8000/api';

// Guardar token después del login
SharedPreferences prefs = await SharedPreferences.getInstance();
await prefs.setString('token', response['token']);

// Incluir token en headers
final token = prefs.getString('token');
final response = await http.get(
  Uri.parse('$baseUrl/biomasas'),
  headers: {
    'Authorization': 'Bearer $token',
    'Accept': 'application/json',
  },
);
```

Para obtener tu IP local:
```bash
ipconfig
# Busca "Dirección IPv4" en tu adaptador de red
```

---

## 🎯 Estado del Proyecto

1. ✅ Panel web funciona en puerto 8000
2. ✅ **API REST completa integrada** (mismo puerto 8000)
3. ✅ **Autenticación Sanctum** (/api/register, /api/login, /api/logout)
4. ✅ **CRUD APIs**: biomasas, focos, tipos, simulaciones, predicciones
5. ✅ **Endpoints públicos**: /api/public/* (sin autenticación)
6. ✅ **Endpoints protegidos**: requieren Bearer token
7. ✅ **Autorización por roles**: middleware role:administrador
8. ✅ Dashboard con mapa Leaflet + focos + biomasas
9. ✅ Clima desde Open-Meteo
10. ✅ Focos desde NASA FIRMS (directo, sin Node.js)
11. ✅ Roles: Administrador / Voluntario
12. ✅ Autenticación web con sesiones (file-based)
13. ✅ **API Resources** para respuestas JSON limpias
14. ❌ sipii-api **OBSOLETO** (mantener solo como referencia histórica)

---

## 📞 Resumen Rápido

| Componente | Puerto | URL | Estado |
|-----------|--------|-----|--------|
| **Panel Web** | 8000 | http://localhost:8000 | ✅ Activo |
| **API REST Completa** | 8000 | http://localhost:8000/api | ✅ Activo |
| **sipii-api** | - | - | ❌ Obsoleto (NO USAR) |
| **Flutter** | - | Conecta a :8000/api | ⏳ Listo para usar |

**¡Todo consolidado en un solo servidor unificado!** 🎉

### 🔑 Flujo de Autenticación API

1. **Registro**: `POST /api/register` → Recibe token
2. **Login**: `POST /api/login` → Recibe token
3. **Uso**: Incluir `Authorization: Bearer {token}` en headers
4. **CRUD**: Acceder a `/api/biomasas`, `/api/focos-incendios`, etc.
5. **Logout**: `POST /api/logout` con token → Revoca token

