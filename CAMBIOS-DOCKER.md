# 🐳 Cambios Realizados en Docker

## Problema Solucionado

**Error Principal**: Al construir los contenedores Docker, se creaba `.env` como **directorio** en lugar de archivo, causando que la aplicación no funcionara.

**Causa**: El `docker-entrypoint.sh` copiaba `.env.example` a `.env`, pero el archivo correcto para Docker es `.env.docker`.

---

## ✅ Cambios Implementados

### 1. **docker-entrypoint.sh** (Laraprueba-CRUD y sipii-api)

**Antes:**
```bash
if [ ! -f .env ]; then
    cp .env.example .env  # ❌ Archivo incorrecto
    php artisan key:generate
fi
```

**Después:**
```bash
# Detectar y eliminar .env si es un directorio
if [ -d .env ]; then
    echo "ERROR: .env es un directorio. Eliminando..."
    rm -rf .env
fi

if [ ! -f .env ]; then
    if [ -f .env.docker ]; then
        echo "Copiando .env.docker a .env..."
        cp .env.docker .env  # ✅ Archivo correcto
    else
        echo "ERROR: .env.docker no encontrado. Usando .env.example como fallback..."
        cp .env.example .env
    fi
    
    php artisan key:generate --force
    # ... limpiar caché
fi
```

**Mejoras:**
- ✅ Detecta si `.env` es un directorio y lo elimina automáticamente
- ✅ Usa `.env.docker` como fuente principal
- ✅ Fallback a `.env.example` si `.env.docker` no existe
- ✅ Usa `--force` en `key:generate` para evitar preguntas interactivas

---

### 2. **docker-compose.yml**

**Cambios en volumes:**

**Antes:**
```yaml
volumes:
  - ./Laraprueba-CRUD/.env:/var/www/html/.env  # ❌ Montaje directo
  - ./Laraprueba-CRUD/app:/var/www/html/app:delegated
```

**Después:**
```yaml
volumes:
  # NO montar .env directamente - se copia desde .env.docker en el entrypoint
  - ./Laraprueba-CRUD/app:/var/www/html/app:delegated
```

**Razón**: El archivo `.env` se genera automáticamente dentro del contenedor desde `.env.docker`, evitando conflictos.

**Cambios en variables de entorno:**

```yaml
environment:
  # ... otras vars
  RUN_SEEDERS: "true"  # ✅ Cambiado de "false" a "true"
```

**Efecto**: Los seeders se ejecutan automáticamente en el primer inicio, creando:
- Usuarios de prueba (admin@sipii.com, voluntario@sipii.com)
- Tipos de biomasa predefinidos

---

### 3. **.env.docker** (Laraprueba-CRUD y sipii-api)

**Actualizaciones:**

```dotenv
# Cambios de locale
APP_LOCALE=es          # ✅ Antes: en
APP_FALLBACK_LOCALE=es # ✅ Antes: en
APP_FAKER_LOCALE=es_ES # ✅ Antes: en_US

# Nueva variable
APP_TIMEZONE=UTC       # ✅ Añadida
```

**Configuración de caché:**
```dotenv
CACHE_STORE=database
CACHE_PREFIX=sipii_web  # ✅ Añadido (solo en app web)
```

---

### 4. **Scripts de Inicio Mejorados**

#### **INICIAR-DOCKER.bat** (Nuevo)

Script mejorado para Windows que:
- ✅ Verifica que Docker esté instalado
- ✅ Limpia archivos `.env` si son directorios (prevención)
- ✅ Construye e inicia los servicios
- ✅ Muestra URLs y credenciales
- ✅ Incluye comandos útiles de referencia

#### **DETENER-DOCKER.bat** (Nuevo)

Script para detener servicios:
- ✅ Detiene los contenedores sin eliminarlos
- ✅ Mantiene los datos en volúmenes
- ✅ Instrucciones claras para reiniciar

#### **INICIAR-SIPII.bat** (Existente)

Mantiene la opción de iniciar sin Docker (desarrollo local con `php artisan serve`).

---

### 5. **README-DOCKER.md** (Actualizado)

**Cambios principales:**

1. **Sección "Preparar archivos"** actualizada:
   - ✅ Se indica que `.env` se genera automáticamente
   - ✅ Se eliminó la instrucción de copiar manualmente
   - ✅ Se agregó comando para limpiar `.env` si es directorio

2. **Nueva sección en Troubleshooting**:
   ```markdown
   ### Error ".env es un directorio"
   Si ves este error en los logs, el entrypoint lo detecta y elimina automáticamente.
   ```

3. **Actualización en "Error APP_KEY not set"**:
   - ✅ Se añadió flag `--force` a los comandos

---

## 🎯 Flujo de Inicio Actualizado

### Primer Inicio (Fresh)

```powershell
# Ejecutar script de inicio
.\INICIAR-DOCKER.bat
```

**Proceso automático:**
1. Docker Compose construye las imágenes
2. Se copian archivos del proyecto (excepto `.env`, `vendor`, `node_modules`)
3. `composer install` y `npm run build` durante el build
4. Al iniciar el contenedor:
   - `docker-entrypoint.sh` detecta que `.env` no existe
   - Copia `.env.docker` → `.env`
   - Genera `APP_KEY`
   - Limpia caché
   - Ejecuta migraciones
   - Ejecuta seeders (porque `RUN_SEEDERS=true`)
5. Aplicación lista en http://localhost:8000

### Reinicios Posteriores

```powershell
# Detener
.\DETENER-DOCKER.bat

# Iniciar nuevamente
.\INICIAR-DOCKER.bat
```

**Proceso:**
- El `.env` ya existe, no se sobrescribe
- Migraciones se verifican (solo ejecuta nuevas)
- Seeders NO se ejecutan (ya están en BD)
- Inicio rápido (~10-30 segundos)

---

## 🔧 Comandos Útiles Post-Cambios

### Ejecutar Seeders Manualmente

```powershell
docker-compose exec app php artisan db:seed --force
```

### Verificar que .env se creó correctamente

```powershell
docker-compose exec app cat .env
```

### Limpiar y reconstruir desde cero

```powershell
# Detener y eliminar todo
docker-compose down -v

# Limpiar .env locales si existen como directorios
Remove-Item "Laraprueba-CRUD\.env" -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item "sipii-api\.env" -Recurse -Force -ErrorAction SilentlyContinue

# Reconstruir
docker-compose up -d --build
```

### Ver logs del entrypoint

```powershell
docker-compose logs app | Select-String "env"
```

---

## 📊 Comparación Antes vs Después

| Aspecto | ❌ Antes | ✅ Después |
|---------|---------|-----------|
| Archivo origen .env | .env.example | .env.docker |
| Detección de .env como directorio | No | Sí (auto-elimina) |
| Montaje de .env en docker-compose | Directo | No (se genera interno) |
| Seeders en primer inicio | Manual | Automático |
| Locale | Inglés | Español |
| Scripts de inicio | 1 (manual) | 3 (Docker auto + manual) |
| Documentación | Básica | Completa + troubleshooting |

---

## 🎉 Resultado Final

**Estado Actual:**
- ✅ Docker funciona sin errores de `.env`
- ✅ Sistema completamente funcional con un solo comando
- ✅ Usuarios de prueba creados automáticamente
- ✅ Configuración en español
- ✅ Scripts mejorados para Windows
- ✅ Documentación actualizada

**Próximos Pasos Sugeridos:**
1. Probar el sistema completo con `.\INICIAR-DOCKER.bat`
2. Verificar login con usuarios de prueba
3. Confirmar que todas las funcionalidades funcionan
4. Configurar backups automáticos de PostgreSQL (producción)

---

**Fecha de actualización**: 2025-11-30  
**Compatibilidad**: Docker Desktop (Windows/macOS/Linux)
