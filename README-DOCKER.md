# 🐳 SIPII Docker - Guía de Uso

Esta guía te ayudará a ejecutar el proyecto SIPII (Web + API) usando Docker y Docker Compose.

## 📋 Requisitos Previos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado (incluye Docker Compose)
- Al menos 4GB de RAM disponible
- 10GB de espacio en disco

## 🏗️ Arquitectura del Proyecto

El proyecto contiene los siguientes servicios:

- **postgres**: Base de datos PostgreSQL 16
- **app**: Aplicación Web Laravel (CRUDs) - Puerto 8000
- **api**: API Laravel - Puerto 8001
- **pgadmin**: Herramienta de administración de PostgreSQL - Puerto 5050 (opcional)

## 🚀 Inicio Rápido

### 1. Preparar archivos de configuración

**IMPORTANTE**: Los archivos `.env` se generan automáticamente desde `.env.docker` al iniciar los contenedores. NO necesitas copiarlos manualmente.

Si anteriormente creaste un `.env` manualmente y tienes problemas:

```powershell
# Eliminar .env si es un directorio (error común)
Remove-Item "Laraprueba-CRUD\.env" -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item "sipii-api\.env" -Recurse -Force -ErrorAction SilentlyContinue
```

Los archivos `.env.docker` ya están configurados con:
- ✅ Conexión a PostgreSQL en Docker
- ✅ Locale en español
- ✅ Configuración de sesiones y caché en base de datos
- ✅ Variables de entorno optimizadas para producción

### 2. Construir e iniciar los contenedores

```powershell
# Construir las imágenes y levantar los servicios
docker-compose up -d --build
```

El parámetro `-d` ejecuta los contenedores en segundo plano (detached mode).

### 3. Verificar que los servicios estén funcionando

```powershell
# Ver el estado de los contenedores
docker-compose ps

# Ver los logs
docker-compose logs -f
```

### 4. Acceder a las aplicaciones

Una vez que los contenedores estén en ejecución:

- **Web App (CRUDs)**: http://localhost:8000
- **API**: http://localhost:8001
- **pgAdmin**: http://localhost:5050
  - Email: `admin@sipii.com`
  - Password: `admin`

## 🔧 Comandos Útiles

### Gestión de Contenedores

```powershell
# Iniciar los servicios
docker-compose up -d

# Detener los servicios
docker-compose stop

# Detener y eliminar los contenedores
docker-compose down

# Detener y eliminar todo (contenedores, volúmenes, imágenes)
docker-compose down -v --rmi all

# Reiniciar un servicio específico
docker-compose restart app
docker-compose restart api
```

### Logs y Debugging

```powershell
# Ver logs de todos los servicios
docker-compose logs -f

# Ver logs de un servicio específico
docker-compose logs -f app
docker-compose logs -f api
docker-compose logs -f postgres

# Ver últimas 100 líneas de logs
docker-compose logs --tail=100 app
```

### Ejecutar Comandos en los Contenedores

```powershell
# Acceder al shell de un contenedor
docker-compose exec app bash
docker-compose exec api bash

# Ejecutar comandos de Artisan en la app web
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:cache

# Ejecutar comandos de Artisan en la API
docker-compose exec api php artisan migrate
docker-compose exec api php artisan route:list
docker-compose exec api php artisan tinker

# Ejecutar Composer
docker-compose exec app composer install
docker-compose exec app composer update

# Ejecutar NPM
docker-compose exec app npm install
docker-compose exec app npm run build
```

### Gestión de la Base de Datos

```powershell
# Acceder a PostgreSQL
docker-compose exec postgres psql -U laravel -d cruds

# Hacer backup de la base de datos
docker-compose exec postgres pg_dump -U laravel cruds > backup.sql

# Restaurar backup
Get-Content backup.sql | docker-compose exec -T postgres psql -U laravel -d cruds

# Crear nueva migración
docker-compose exec app php artisan make:migration create_example_table

# Ejecutar migraciones
docker-compose exec app php artisan migrate

# Rollback migraciones
docker-compose exec app php artisan migrate:rollback

# Refrescar base de datos (⚠️ Elimina todos los datos)
docker-compose exec app php artisan migrate:fresh --seed
```

## 🔄 Reconstruir Servicios

Si realizas cambios en el código, a veces necesitarás reconstruir las imágenes:

```powershell
# Reconstruir todos los servicios
docker-compose up -d --build

# Reconstruir un servicio específico
docker-compose up -d --build app
docker-compose up -d --build api

# Forzar reconstrucción sin caché
docker-compose build --no-cache app
docker-compose up -d app
```

## 🗃️ Gestión de Volúmenes

Los datos persistentes se almacenan en volúmenes Docker:

```powershell
# Listar volúmenes
docker volume ls

# Inspeccionar un volumen
docker volume inspect laraprueba-crud_postgres_data

# Eliminar volúmenes no utilizados (⚠️ Cuidado con los datos)
docker volume prune
```

## 🔍 Troubleshooting

### Los contenedores no inician

```powershell
# Verificar logs para identificar el error
docker-compose logs

# Verificar que los puertos no estén ocupados
netstat -ano | findstr ":8000"
netstat -ano | findstr ":8001"
netstat -ano | findstr ":5432"

# Eliminar contenedores antiguos y volver a crear
docker-compose down
docker-compose up -d --force-recreate
```

### Error "APP_KEY not set"

El `docker-entrypoint.sh` genera automáticamente la APP_KEY. Si aún así tienes este error:

```powershell
# Generar una nueva APP_KEY
docker-compose exec app php artisan key:generate --force
docker-compose exec api php artisan key:generate --force

# Reiniciar los servicios
docker-compose restart app api
```

### Error ".env es un directorio"

Si ves este error en los logs, significa que se creó `.env` como carpeta por error:

```powershell
# El entrypoint lo detecta y elimina automáticamente
# Pero si persiste, ejecuta:
docker-compose down
Remove-Item "Laraprueba-CRUD\.env" -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item "sipii-api\.env" -Recurse -Force -ErrorAction SilentlyContinue
docker-compose up -d
```

### Error de permisos en storage

```powershell
# Dentro del contenedor, ajustar permisos
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/storage

docker-compose exec api chown -R www-data:www-data /var/www/html/storage
docker-compose exec api chmod -R 775 /var/www/html/storage
```

### PostgreSQL no se conecta

```powershell
# Verificar que PostgreSQL esté saludable
docker-compose ps postgres

# Probar conexión manualmente
docker-compose exec postgres pg_isready -U laravel

# Reiniciar PostgreSQL
docker-compose restart postgres
```

### Limpiar todo y empezar de cero

```powershell
# ⚠️ ADVERTENCIA: Esto eliminará TODOS los datos
docker-compose down -v
docker-compose up -d --build
```

## 🔐 Configuración de pgAdmin

Para conectar pgAdmin a PostgreSQL:

1. Accede a http://localhost:5050
2. Login con: `admin@sipii.com` / `admin`
3. Click derecho en "Servers" → "Register" → "Server"
4. En la pestaña "General":
   - Name: `SIPII PostgreSQL`
5. En la pestaña "Connection":
   - Host: `postgres`
   - Port: `5432`
   - Database: `cruds`
   - Username: `laravel`
   - Password: `laravel`

## 📊 Monitoreo de Recursos

```powershell
# Ver uso de recursos de los contenedores
docker stats

# Ver uso de recursos de un contenedor específico
docker stats sipii-app

# Ver procesos dentro de un contenedor
docker-compose top app
```

## 🚨 Producción

Para desplegar en producción:

1. **Cambiar credenciales** en el `.env`:
   - Genera passwords seguros para PostgreSQL
   - Cambia las credenciales de pgAdmin
   - Configura `APP_ENV=production`
   - Configura `APP_DEBUG=false`

2. **Configurar HTTPS**:
   - Usa un reverse proxy como Nginx o Traefik
   - Configura certificados SSL

3. **Optimizar Laravel**:
```powershell
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app composer install --optimize-autoloader --no-dev
```

4. **Backups automáticos** de PostgreSQL

## 📝 Notas Importantes

- Los archivos `.env` **no** se copian al contenedor gracias a `.dockerignore`
- Las variables de entorno se configuran en `docker-compose.yml`
- Los volúmenes persisten los datos incluso si eliminas los contenedores
- El script `docker-entrypoint.sh` ejecuta migraciones automáticamente al iniciar

## 🆘 Soporte

Si encuentras problemas:

1. Revisa los logs: `docker-compose logs -f`
2. Verifica el estado: `docker-compose ps`
3. Reinicia los servicios: `docker-compose restart`
4. Consulta la documentación oficial de [Docker](https://docs.docker.com/) y [Laravel](https://laravel.com/docs)

---

**Autor**: GitHub Copilot
**Fecha**: 2025-11-26
