# Simulador Avanzado de Incendios

## Descripción
Sistema de simulación en tiempo real de propagación de incendios forestales con factores ambientales dinámicos.

## Características Principales

### 1. Interfaz Interactiva
- **Mapa Leaflet**: Click para añadir focos de incendio
- **Controles en tiempo real**: Temperatura, humedad, viento
- **Visualización dinámica**: Círculos de propagación con colores según intensidad

### 2. Parámetros Ambientales
- **Temperatura**: 0-50°C (afecta velocidad de propagación)
- **Humedad**: 0-100% (reduce propagación)
- **Velocidad del viento**: 0-100 km/h (acelera propagación)
- **Dirección del viento**: 0-360° (determina dirección de propagación)
- **Velocidad de simulación**: 0.1-5x

### 3. Algoritmo de Propagación
Cada foco activo tiene **probabilidad de expandirse** basada en el riesgo de incendio:

**Probabilidad de expansión**: `fireRisk / 100` (0% a 100%)
- Con 30% de riesgo → 30% probabilidad de crear nuevo foco cada segundo
- Con 80% de riesgo → 80% probabilidad de crear nuevo foco cada segundo

**Reglas de supervivencia**:
- Si un foco **NO se expande por 5 segundos**, desaparece automáticamente
- Cada vez que un foco se expande, reinicia su contador de supervivencia

**Cuando se expande**:
```javascript
spreadRate = (fireRisk/100) × (windSpeed/20) × (temperature/30) × (1 - humidity/150)
spreadDistance = 0.01 × spreadRate × simulationSpeed

// Dirección: viento ± 30° aleatorio
// Nuevo foco con 95% de la intensidad del anterior
```

**Fusión de focos**: Cuando dos focos están a menos de 0.02 grados de distancia, se fusionan aumentando la intensidad del existente.

### 4. Cálculo de Riesgo de Incendio
```php
fireRisk = (tempFactor × 0.4) + (humidityFactor × 0.3) + (windFactor × 0.3)
```
- Verde (0-40%): Riesgo bajo
- Amarillo (41-70%): Riesgo medio
- Rojo (71-100%): Riesgo alto

### 5. Cálculo de Voluntarios
```javascript
volunteers = base(5) + (intensity × 2) + (area × 0.1)
```

### 6. Estrategias de Mitigación
Sistema automático que recomienda:
- Activación de protocolos de emergencia
- Despliegue de recursos (bomberos, voluntarios)
- Alertas especiales por condiciones climáticas
- Humectación de áreas circundantes

## Funcionalidades

### Simulación
1. Click en el mapa para añadir focos iniciales
2. Ajustar parámetros ambientales con sliders
3. Iniciar simulación
4. Observar propagación en tiempo real
5. Detener cuando se desee

### Guardado
- Guardar simulación completa con:
  - Nombre personalizado
  - Todos los parámetros ambientales
  - Historial completo de focos
  - Estrategias de mitigación
  - Voluntarios calculados

### Historial
- Ver últimas 10 simulaciones
- Repetir simulación con parámetros exactos
- Eliminar simulaciones antiguas
- Descargar como JSON

### Auto-stop
- Simulación se detiene automáticamente a las 20h
- Flag `auto_stopped` en base de datos

## Base de Datos

### Tabla: `simulaciones`
```sql
- environmental_params: temperature, humidity, wind_speed, wind_direction
- simulation_speed, fire_risk
- map_center_lat, map_center_lng
- initial_fires (JSON): array de focos iniciales
- mitigation_strategies (JSON): array de recomendaciones
- auto_stopped (boolean)
```

### Tabla: `simulation_fire_history`
```sql
- simulacion_id, fire_id, time_step
- lat, lng, intensity, spread, active
- Index: (simulacion_id, time_step)
```

## Rutas API

```php
GET  /simulaciones/simulator          → Vista del simulador
POST /simulaciones/save-simulation   → Guardar simulación
GET  /simulaciones/history            → Últimas 10 simulaciones
DELETE /simulaciones/delete/{id}      → Eliminar simulación
```

## Tecnologías
- **Backend**: Laravel 12.37.0, PHP 8.2.12
- **Frontend**: Blade, Alpine.js 3.x
- **Mapas**: Leaflet.js 1.9.4
- **Base de datos**: PostgreSQL con JSON columns
- **AdminLTE**: 3.x para interfaz

## Ubicación Predeterminada
San José de Chiquitos, Bolivia: [-17.8, -61.5]

## Límites del Sistema
- Máximo 50 focos activos simultáneos
- Cada foco genera **1 nuevo foco** si la probabilidad (fireRisk%) se cumple
- Desactivación automática si no se expande por **5 segundos**
- Dirección de propagación: viento ± 30° aleatorio
- Distancia de fusión de focos: 0.02 grados
- Intensidad mínima para seguir activo: 0.2
- Desactivación automática cuando spreadRate < 0.001

## Acceso
- **Dashboard**: Card "Simulador Avanzado"
- **Menú lateral**: "Simulador Avanzado" (con ícono de fuego)
- **Index de simulaciones**: Botón "Simulador Avanzado"
- **URL directa**: `/simulaciones/simulator`
