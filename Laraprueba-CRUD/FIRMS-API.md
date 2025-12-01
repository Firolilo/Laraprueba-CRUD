# NASA FIRMS API - Configuración

## 🔥 Endpoint Actualizado

El servicio `FirmsDataService` ahora usa el endpoint de **ÁREA** en lugar del endpoint de países (que actualmente no está disponible).

### ✨ Nuevo: Sistema de Clustering

Los focos de calor cercanos se agrupan automáticamente en **puntos calientes** para:
- Reducir la cantidad de marcadores en el mapa (68% de reducción con radio 2km)
- Identificar zonas críticas de incendio
- Mejorar el rendimiento de visualización
- Facilitar la toma de decisiones

**Ejemplo:** 529 focos individuales → 167 puntos calientes (radio 2km)

## 📍 Coordenadas de la Chiquitanía

### Área Configurada
```
Región: Chiquitanía, Santa Cruz, Bolivia
Coordenadas: -62.5,-18.5,-57.5,-14.5
Formato: west,south,east,north
```

### Bounding Box
- **West (Oeste):** -62.5°
- **South (Sur):** -18.5°
- **East (Este):** -57.5°
- **North (Norte):** -14.5°

Esta área cubre aproximadamente:
- San José de Chiquitos
- Roboré
- Puerto Suárez
- Santiago de Chiquitos
- Y zonas circundantes de la Chiquitanía

## 🌐 Formato de URL

### Endpoint Actual
```
GET /api/area/csv/{MAP_KEY}/{SOURCE}/{AREA_COORDINATES}/{DAY_RANGE}
```

### Ejemplo de Uso
```
https://firms.modaps.eosdis.nasa.gov/api/area/csv/YOUR_API_KEY/VIIRS_NOAA20_NRT/-62.5,-18.5,-57.5,-14.5/1
```

## 🛠️ Personalización de Área

### En el Código

Para cambiar el área de búsqueda o parámetros de clustering, modifica las coordenadas en:

1. **FirmsDataService.php** (valores por defecto):
```php
public function getFireData(
    string $product = 'VIIRS_NOAA20_NRT', 
    string $area = '-62.5,-18.5,-57.5,-14.5',  // Área
    int $days = 3,                              // Días (ahora 3 por defecto)
    bool $cluster = true,                       // ← Clustering activado
    float $clusterRadius = 2.0                  // ← Radio de 2km
): array
```

2. **DashboardController.php**:
```php
$firesData = $firms->getFireData(
    'VIIRS_NOAA20_NRT', 
    '-62.5,-18.5,-57.5,-14.5',    // Área (west,south,east,north)
    3,                             // Últimos 3 días
    true,                          // Clustering activado
    2.0                            // Radio de 2km
);
```

3. **API FiresController.php**:
```php
$cluster = filter_var($request->query('cluster', 'true'), FILTER_VALIDATE_BOOLEAN);
$radius = (float) $request->query('radius', 2.0);  // Radio por defecto: 2km
```

### Via API Request

También puedes especificar parámetros personalizados al hacer la petición:

```bash
# Con clustering (por defecto)
GET /api/fires?area=-62.5,-18.5,-57.5,-14.5&days=3&cluster=true&radius=2

# Sin clustering (focos individuales)
GET /api/fires?area=-62.5,-18.5,-57.5,-14.5&days=3&cluster=false

# Clustering con radio personalizado
GET /api/fires?area=-62.5,-18.5,-57.5,-14.5&days=3&radius=5
```

## 🎯 Sistema de Clustering

### Algoritmo

Utiliza un algoritmo tipo DBSCAN que:
1. Agrupa focos dentro del radio especificado
2. Calcula el centroide ponderado por FRP (Fire Radiative Power)
3. Mantiene la confianza máxima del cluster
4. Suma la potencia radiativa total

### Comparación de Radios

| Radio | Puntos Calientes | Reducción | Porcentaje |
|-------|-----------------|-----------|------------|
| 0.5 km | 220 | 309 | 58.4% |
| 1 km | 175 | 354 | 66.9% |
| **2 km** | **167** | **362** | **68.4%** ✓ |
| 5 km | 135 | 394 | 74.5% |
| 10 km | 98 | 431 | 81.5% |

**Recomendación:** Radio de 2km para balance óptimo entre detalle y rendimiento.

## 📊 Productos Disponibles

- `VIIRS_NOAA20_NRT` (por defecto, recomendado - 375m resolución)
- `VIIRS_SNPP_NRT` (375m resolución)
- `MODIS_NRT` (1km resolución)

## ⏱️ Configuración Actual

- **Días consultados:** 3 (últimos 3 días)
- **Clustering:** Activado por defecto
- **Radio de clustering:** 2 km
- **Caché:** 10 minutos por configuración única

## 🌍 Otras Áreas de Interés

### Bolivia Completa
```
-69.5,-22.5,-57.5,-9.5
```

### Santa Cruz (Departamento)
```
-63.5,-20.5,-57.5,-14.5
```

### Mundo Completo
```
world
o
-180,-90,180,90
```

## 🔑 Configuración de API Key

Asegúrate de tener tu clave de API en `.env`:

```env
FIRMS_API_KEY=tu_clave_aqui
```

Obtén tu clave gratuitamente en:
https://firms.modaps.eosdis.nasa.gov/api/area/

## 📝 Datos Retornados

### Para Focos Individuales (cluster=false)
Cada foco incluye:
- `lat`: Latitud
- `lng`: Longitud
- `date`: Fecha de detección (YYYY-MM-DD)
- `time`: Hora de detección (HHMM)
- `confidence`: Nivel de confianza (n=normal, h=high, l=low)
- `frp`: Fire Radiative Power (potencia del fuego en MW)

### Para Puntos Calientes (cluster=true) 
Cada punto incluye:
- `lat`: Latitud del centroide
- `lng`: Longitud del centroide
- `date`: Fecha de primera detección
- `time`: Hora de primera detección
- `confidence`: Confianza máxima del cluster (h > n > l)
- `frp`: Potencia radiativa total del cluster
- `cluster_size`: Número de focos agrupados
- `is_cluster`: true si agrupa múltiples focos
- `dates`: Array de fechas únicas de detección

## 🚀 Uso en la Aplicación

### Dashboard
Los puntos calientes se muestran automáticamente en el mapa del dashboard (últimos 3 días, agrupados con radio 2km).

### API Endpoint
```
GET /api/fires
```

Parámetros opcionales:
- `area`: Coordenadas del bounding box (string)
- `product`: Sensor satelital (string) 
- `days`: Número de días a consultar (1-10), default: 3
- `cluster`: Activar clustering (true/false), default: true
- `radius`: Radio de clustering en km (0.5-10), default: 2.0

#### Ejemplos de uso:
```bash
# Datos agrupados (por defecto)
curl "http://localhost:8000/api/fires"

# Sin agrupar (focos individuales)  
curl "http://localhost:8000/api/fires?cluster=false"

# Clustering con radio de 5km
curl "http://localhost:8000/api/fires?radius=5&days=7"

# Área personalizada
curl "http://localhost:8000/api/fires?area=-65,-20,-55,-15&days=3"
```

## 🔍 Respuesta de la API

### Con Clustering (por defecto):
```json
{
  "ok": true,
  "status": 200,
  "data": [
    {
      "lat": -18.2850,
      "lng": -62.1232,
      "date": "2025-11-29",
      "time": "508",
      "confidence": "h",
      "frp": 22.48,
      "cluster_size": 6,
      "is_cluster": true,
      "dates": ["2025-11-29", "2025-11-28"]
    }
  ],
  "count": 167,
  "cached": false
}
```

### Sin Clustering:
```json
{
  "ok": true,
  "status": 200,
  "data": [
    {
      "lat": -17.5234,
      "lng": -60.1234,
      "date": "2025-11-30",
      "time": "1420",
      "confidence": "h",
      "frp": 3.74
    }
  ],
  "count": 529,
  "cached": false
}
```

## 📝 Límites de la API

- **Máximo de días:** 10
- **Actualización:** Datos en tiempo casi real (NRT = Near Real-Time)
- **Límite de peticiones:** Según tu plan de API
- **Bounding box máximo:** -180,-90,180,90
- **Radio de clustering:** 0.5 - 10 km

## ⚠️ Notas Importantes

1. **El endpoint de países (`/api/country/`) NO está funcionando actualmente** según la documentación oficial de NASA FIRMS.
2. Usa siempre el endpoint de área (`/api/area/`) como se implementa en este proyecto.
3. Las coordenadas deben estar en formato decimal (no grados/minutos/segundos).
4. El formato es siempre: `west,south,east,north` (longitud_mínima, latitud_mínima, longitud_máxima, latitud_máxima).
5. **El clustering está activado por defecto** con radio de 2km para optimizar la visualización.
