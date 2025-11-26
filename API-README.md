# 🔥 API de Sistema de Predicción de Incendios

API REST para el sistema de predicción y simulación de incendios forestales, con soporte para biomasas y análisis geoespacial.

## 🚀 Base URL

```
http://localhost:8000/api
```

## 🔐 Autenticación

La API usa **Laravel Sanctum** para autenticación con tokens Bearer.

### Registro de Usuario

**POST** `/register`

```json
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
  "user": {
    "id": 1,
    "name": "Juan Pérez",
    "email": "juan@example.com"
  },
  "token": "1|abc123token..."
}
```

### Login

**POST** `/login`

```json
{
  "email": "juan@example.com",
  "password": "password123"
}
```

**Respuesta:**
```json
{
  "message": "Inicio de sesión exitoso",
  "user": {
    "id": 1,
    "name": "Juan Pérez",
    "email": "juan@example.com"
  },
  "token": "2|xyz456token..."
}
```

### Logout

**POST** `/logout`

Headers: `Authorization: Bearer {token}`

**Respuesta:**
```json
{
  "message": "Sesión cerrada exitosamente"
}
```

### Usar Token en Peticiones

Todas las peticiones protegidas requieren el header:

```
Authorization: Bearer {tu-token-aqui}
```

---

## 📍 Endpoints

### 🔥 Focos de Incendio

#### Listar todos los focos
**GET** `/focos-incendios`

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "fecha": "2025-11-24T10:00:00.000000Z",
      "ubicacion": "Zona Norte - San José",
      "coordenadas": [-17.75, -61.45],
      "intensidad": 7.5,
      "created_at": "2025-11-25T...",
      "updated_at": "2025-11-25T...",
      "predictions": []
    }
  ]
}
```

#### Crear nuevo foco
**POST** `/focos-incendios`

```json
{
  "fecha": "2025-11-26T14:30:00Z",
  "ubicacion": "Bosque Chiquitano",
  "coordenadas": [-17.82, -61.52],
  "intensidad": 8.5
}
```

#### Ver foco específico
**GET** `/focos-incendios/{id}`

#### Actualizar foco
**PUT** `/focos-incendios/{id}`

#### Eliminar foco
**DELETE** `/focos-incendios/{id}`

---

### 🌿 Biomasas

#### Listar biomasas
**GET** `/biomasas`

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "tipo_biomasa_id": 1,
      "densidad": "Alta",
      "coordenadas": [
        [-17.75, -61.45],
        [-17.76, -61.46],
        [-17.77, -61.45]
      ],
      "area_m2": 150000,
      "perimetro_m": 2500,
      "descripcion": "Zona de pastizal seco",
      "fecha_reporte": "2025-11-25",
      "tipo_biomasa": {
        "id": 1,
        "tipo_biomasa": "Pastizal",
        "color": "#FFD700",
        "modificador_intensidad": 1.5
      },
      "user": {
        "id": 1,
        "name": "Juan Pérez"
      }
    }
  ]
}
```

#### Crear biomasa
**POST** `/biomasas`

```json
{
  "tipo_biomasa_id": 1,
  "densidad": "Alta",
  "coordenadas": [
    [-17.75, -61.45],
    [-17.76, -61.46],
    [-17.77, -61.45]
  ],
  "area_m2": 150000,
  "perimetro_m": 2500,
  "descripcion": "Zona de pastizal seco",
  "fecha_reporte": "2025-11-25"
}
```

#### Ver biomasa específica
**GET** `/biomasas/{id}`

#### Actualizar biomasa
**PUT** `/biomasas/{id}`

#### Eliminar biomasa
**DELETE** `/biomasas/{id}`

---

### 🎨 Tipos de Biomasa

#### Listar tipos
**GET** `/tipos-biomasa`

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "tipo_biomasa": "Pastizal",
      "color": "#FFD700",
      "modificador_intensidad": 1.5,
      "biomasas_count": 5
    }
  ]
}
```

#### Crear tipo
**POST** `/tipos-biomasa`

```json
{
  "tipo_biomasa": "Bosque Húmedo",
  "color": "#228B22",
  "modificador_intensidad": 0.7
}
```

---

### 📊 Predicciones

#### Listar predicciones
**GET** `/predictions`

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "foco_incendio_id": 1,
      "predicted_at": "2025-11-25T10:00:00.000000Z",
      "path": [...],
      "meta": {
        "temperature": 25,
        "humidity": 50,
        "wind_speed": 10
      },
      "foco_incendio": {...}
    }
  ]
}
```

#### Crear predicción
**POST** `/predictions`

```json
{
  "foco_incendio_id": 1,
  "temperature": 30,
  "humidity": 40,
  "wind_speed": 15,
  "wind_direction": 90,
  "prediction_hours": 24,
  "terrain_type": "bosque"
}
```

#### Ver predicción
**GET** `/predictions/{id}`

#### Eliminar predicción
**DELETE** `/predictions/{id}`

---

### 🎮 Simulaciones

#### Listar simulaciones
**GET** `/simulaciones`

#### Crear simulación
**POST** `/simulaciones`

```json
{
  "nombre": "Simulación Norte 2025",
  "admin_id": 1,
  "parameters": {
    "temperature": 25,
    "humidity": 50,
    "windSpeed": 10,
    "windDirection": 0,
    "simulationSpeed": 1
  },
  "initial_fires": [
    {"lat": -17.8, "lng": -61.5, "intensity": 5}
  ],
  "history": []
}
```

#### Ver simulación
**GET** `/simulaciones/{id}`

#### Eliminar simulación
**DELETE** `/simulaciones/{id}`

---

## 🌐 Endpoints Públicos (Sin autenticación)

```
GET /public/focos-incendios
GET /public/tipos-biomasa
```

---

## 📱 Ejemplo de Uso en Flutter/React Native

### Flutter (Dart)

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiService {
  final String baseUrl = 'http://localhost:8000/api';
  String? token;
  
  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Content-Type': 'application/json'},
      body: json.encode({'email': email, 'password': password}),
    );
    
    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      token = data['token'];
      return data;
    }
    throw Exception('Login failed');
  }
  
  Future<List<dynamic>> getFocos() async {
    final response = await http.get(
      Uri.parse('$baseUrl/focos-incendios'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );
    
    if (response.statusCode == 200) {
      return json.decode(response.body)['data'];
    }
    throw Exception('Failed to load focos');
  }
}
```

### React Native (JavaScript)

```javascript
const API_URL = 'http://localhost:8000/api';
let authToken = null;

async function login(email, password) {
  const response = await fetch(`${API_URL}/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ email, password }),
  });
  
  const data = await response.json();
  authToken = data.token;
  return data;
}

async function getBiomasas() {
  const response = await fetch(`${API_URL}/biomasas`, {
    headers: {
      'Authorization': `Bearer ${authToken}`,
      'Accept': 'application/json',
    },
  });
  
  const data = await response.json();
  return data.data;
}
```

---

## 🛡️ Códigos de Estado HTTP

- `200` - OK (Operación exitosa)
- `201` - Created (Recurso creado)
- `400` - Bad Request (Datos inválidos)
- `401` - Unauthorized (Token inválido/expirado)
- `404` - Not Found (Recurso no encontrado)
- `422` - Unprocessable Entity (Validación fallida)
- `500` - Internal Server Error

---

## 🔧 Configuración

### Variables de Entorno

```env
# .env
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
SESSION_DRIVER=cookie
```

### CORS

El proyecto está configurado para permitir todas las peticiones en desarrollo. Para producción, edita `config/cors.php`:

```php
'allowed_origins' => [
    'https://tu-app.com',
    'https://app.tuapp.com',
],
```

---

## 🧪 Testing con Postman/Insomnia

1. **Registrar usuario:** POST `/api/register`
2. **Copiar el token** de la respuesta
3. **Agregar header** en todas las peticiones:
   ```
   Authorization: Bearer {tu-token}
   ```
4. **Hacer peticiones** a los endpoints protegidos

---

## 📝 Notas Importantes

- Los tokens no expiran por defecto (puedes configurar expiración en Sanctum)
- Los campos `coordenadas` se guardan como JSON pero se devuelven como arrays
- Las biomasas requieren mínimo 3 coordenadas para formar un polígono
- Las predicciones incluyen detección automática de biomasas usando Ray Casting
- Los modificadores de intensidad afectan la propagación del fuego

---

## 🎯 Próximos Pasos

Para tu app móvil:

1. Implementa login y guarda el token en storage local
2. Crea servicios para consumir cada endpoint
3. Usa Leaflet/Mapbox para visualizar mapas
4. Implementa caché local para mejor performance
5. Agrega sincronización offline

---

**¡Tu API REST está lista! 🚀**
