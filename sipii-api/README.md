# SIPII API

API REST para el Sistema de Información de Prevención de Incendios.

## 🚀 Inicio Rápido

### Ejecutar el servidor
```bash
cd "C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\sipii-api"
php artisan serve --port=8001
```

La API estará disponible en: **http://localhost:8001**

## 📊 Base de Datos

Comparte la misma base de datos PostgreSQL con la aplicación web principal:
- **Base de datos:** cruds
- **Usuario:** laravel
- **Password:** laravel
- **Puerto:** 5432

## 📝 Endpoints Disponibles

### Focos de Incendio
```
GET    /api/focos-incendios       - Listar todos
POST   /api/focos-incendios       - Crear nuevo
GET    /api/focos-incendios/{id}  - Ver detalle
PUT    /api/focos-incendios/{id}  - Actualizar
DELETE /api/focos-incendios/{id}  - Eliminar
```

### Biomasas
```
GET    /api/biomasas       - Listar todas
POST   /api/biomasas       - Crear nueva
GET    /api/biomasas/{id}  - Ver detalle
PUT    /api/biomasas/{id}  - Actualizar
DELETE /api/biomasas/{id}  - Eliminar
```

### Tipos de Biomasa
```
GET    /api/tipos-biomasa       - Listar todos
POST   /api/tipos-biomasa       - Crear nuevo
GET    /api/tipos-biomasa/{id}  - Ver detalle
PUT    /api/tipos-biomasa/{id}  - Actualizar
DELETE /api/tipos-biomasa/{id}  - Eliminar
```

## 🔐 Autenticación

**Actualmente sin autenticación** - Todos los endpoints están abiertos para desarrollo.

## 📱 Uso desde Flutter

```dart
static const String baseUrl = 'http://192.168.0.27:8001/api';
```

## ⚠️ Importante

- Esta aplicación es **SOLO para la API**
- Para panel web, usa la app en puerto 8000
- Comparte base de datos con la aplicación web
