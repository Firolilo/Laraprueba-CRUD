#!/bin/bash
set -e

echo "Esperando a que PostgreSQL esté listo..."
until php artisan migrate:status 2>/dev/null; do
    echo "PostgreSQL no está listo - esperando..."
    sleep 2
done

echo "PostgreSQL está listo!"

# Copiar .env.docker a .env si no existe o si .env es un directorio (error común)
if [ -d .env ]; then
    echo "ERROR: .env es un directorio. Eliminando..."
    rm -rf .env
fi

if [ ! -f .env ]; then
    if [ -f .env.docker ]; then
        echo "Copiando .env.docker a .env..."
        cp .env.docker .env
    else
        echo "ERROR: .env.docker no encontrado. Usando .env.example como fallback..."
        cp .env.example .env
    fi
    
    echo "Generando application key..."
    php artisan key:generate --force
    
    # Limpiar caché solo en primera ejecución
    echo "Limpiando caché..."
    php artisan config:clear || true
    php artisan cache:clear || true
    php artisan route:clear || true
    php artisan view:clear || true
fi

# Crear enlace simbólico de storage (solo si no existe)
if [ ! -L public/storage ]; then
    echo "Creando enlace simbólico de storage..."
    php artisan storage:link || true
fi

# Verificar migraciones (solo si es necesario)
echo "Verificando migraciones..."
php artisan migrate --force

# Ejecutar seeders si existen
if [ "$RUN_SEEDERS" = "true" ]; then
    echo "Ejecutando seeders..."
    php artisan db:seed --force
fi

echo "API lista!"

# Ejecutar el comando CMD del Dockerfile
exec "$@"
