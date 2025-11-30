#!/bin/bash
set -e

echo "Esperando a que PostgreSQL esté listo..."
until php artisan migrate:status 2>/dev/null; do
    echo "PostgreSQL no está listo - esperando..."
    sleep 2
done

echo "PostgreSQL está listo!"

# Generar key si no existe
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Generando application key..."
    php artisan key:generate
    
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

echo "Aplicación lista!"

# Ejecutar el comando CMD del Dockerfile
exec "$@"
