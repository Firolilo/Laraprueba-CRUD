# ✅ SIPII - Aplicaciones Separadas Configuradas

## 🎉 TODO LISTO - Ya puedes usar ambas aplicaciones

### 📁 Estructura Final

```
Laraprueba-CRUD/
├── Laraprueba-CRUD/          # Panel Web AdminLTE (Puerto 8000)
├── sipii-api/                 # API REST (Puerto 8001)  
├── sipii_flutter/             # App móvil Flutter
├── INICIAR-SIPII.bat          # Script para iniciar ambos servidores
└── LEEME-ESTRUCTURA.md        # Este archivo
```

---

## 🚀 Iniciar Todo el Sistema

### Opción 1: Script Automático (Recomendado)
Doble clic en: **`INICIAR-SIPII.bat`**

### Opción 2: Manual

**Terminal 1 - Panel Web:**
```bash
cd "C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD"
php artisan serve --port=8000
```

**Terminal 2 - API:**
```bash
cd "C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\sipii-api"
php artisan serve --port=8001
```

---

## 🌐 Aplicaciones

### 1. Panel Web AdminLTE
- **URL:** http://localhost:8000
- **Uso:** Administración visual con tablas, formularios y mapas
- **Características:**
  - ✅ CRUD de focos de incendio
  - ✅ CRUD de biomasas
  - ✅ CRUD de tipos de biomasa
  - ✅ Simulador de incendios
  - ✅ Gestión de usuarios
  - ✅ Predicciones con mapas

### 2. API REST
- **URL:** http://localhost:8001/api
- **Uso:** Endpoints JSON para app móvil
- **Características:**
  - ✅ GET/POST/PUT/DELETE focos-incendios
  - ✅ GET/POST/PUT/DELETE biomasas
  - ✅ GET/POST/PUT/DELETE tipos-biomasa
  - ✅ Sin autenticación (desarrollo)
  - ✅ Respuestas JSON

### 3. App Móvil Flutter
- **Conexión:** http://192.168.0.27:8001/api
- **Estado:** ✅ Configurada para usar nueva API
- **Funcionalidades:**
  - ✅ Mapa con focos de incendio
  - ✅ Polígonos de biomasas con colores
  - ✅ Compartir por WhatsApp/Otras apps
  - ✅ Click en polígonos para detalles

---

## 📊 Base de Datos

**Ambas aplicaciones comparten la MISMA base de datos:**
- Base de datos: `cruds`
- Usuario: `laravel`
- Password: `laravel`
- Puerto: `5432`
- Tipo: PostgreSQL

---

## 📝 Endpoints API

### Focos de Incendio
```
GET    http://localhost:8001/api/focos-incendios
POST   http://localhost:8001/api/focos-incendios
GET    http://localhost:8001/api/focos-incendios/{id}
PUT    http://localhost:8001/api/focos-incendios/{id}
DELETE http://localhost:8001/api/focos-incendios/{id}
```

### Biomasas
```
GET    http://localhost:8001/api/biomasas
POST   http://localhost:8001/api/biomasas
GET    http://localhost:8001/api/biomasas/{id}
PUT    http://localhost:8001/api/biomasas/{id}
DELETE http://localhost:8001/api/biomasas/{id}
```

### Tipos de Biomasa
```
GET    http://localhost:8001/api/tipos-biomasa
POST   http://localhost:8001/api/tipos-biomasa
GET    http://localhost:8001/api/tipos-biomasa/{id}
PUT    http://localhost:8001/api/tipos-biomasa/{id}
DELETE http://localhost:8001/api/tipos-biomasa/{id}
```

---

## ⚠️ Reglas Importantes

### ✅ Hacer:
- Usar **puerto 8000** para panel web en el navegador
- Usar **puerto 8001** para API desde Flutter
- Ambas apps pueden leer/escribir en la BD

### ❌ NO Hacer:
- NO acceder a `/api/*` en el puerto 8000 (web)
- NO abrir el puerto 8001 en el navegador (es solo API)
- NO mezclar las aplicaciones

---

## 🔧 Comandos Útiles

### Panel Web
```bash
cd Laraprueba-CRUD
php artisan optimize:clear    # Limpiar cachés
php artisan route:list         # Ver rutas web
```

### API
```bash
cd sipii-api
php artisan route:list         # Ver endpoints API
php artisan tinker             # Consola interactiva
```

---

## 📱 Configurar App Flutter

La app ya está configurada, pero si necesitas cambiar la IP:

```dart
// lib/services/api_service.dart
static const String baseUrl = 'http://TU_IP_LOCAL:8001/api';
```

Para obtener tu IP local:
```bash
ipconfig
# Busca "Dirección IPv4" en tu adaptador de red
```

---

## 🎯 Próximos Pasos

1. ✅ Panel web funciona en puerto 8000
2. ✅ API funciona en puerto 8001  
3. ✅ App Flutter conectada a API
4. ⏭️ Agregar datos de prueba desde el panel web
5. ⏭️ Verificar que aparezcan en la app móvil
6. ⏭️ Implementar autenticación (futuro)

---

## 🆘 Solución de Problemas

**Panel web muestra error al guardar:**
- Asegúrate de estar en puerto 8000
- NO uses rutas `/api/*` en el navegador

**App móvil no muestra datos:**
- Verifica que API esté en puerto 8001
- Cambia IP en Flutter a tu IP local
- Ejecuta `ipconfig` para ver tu IP

**Base de datos vacía:**
- Usa el panel web (puerto 8000) para agregar datos
- Los datos aparecerán automáticamente en la API

---

## 📞 Resumen Rápido

| Aplicación | Puerto | URL | Uso |
|-----------|--------|-----|-----|
| **Panel Web** | 8000 | http://localhost:8000 | Administración visual |
| **API REST** | 8001 | http://localhost:8001/api | App móvil |
| **Flutter** | - | Conecta a API:8001 | App móvil |

**¡Todo está listo para usar!** 🎉

