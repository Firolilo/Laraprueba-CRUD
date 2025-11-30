@echo off
chcp 65001 > nul
cls
echo ========================================
echo 🐳 SIPII - Iniciando con Docker
echo ========================================
echo.

REM Verificar si Docker está instalado
docker --version > nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ ERROR: Docker no está instalado o no está en el PATH
    echo.
    echo Instala Docker Desktop desde: https://www.docker.com/products/docker-desktop/
    echo.
    pause
    exit /b 1
)

echo ✅ Docker detectado
echo.

REM Limpiar archivos .env si son directorios (error común)
echo 🧹 Limpiando archivos .env anteriores...
if exist "Laraprueba-CRUD\.env\" (
    echo    - Eliminando directorio .env en Laraprueba-CRUD...
    rmdir /s /q "Laraprueba-CRUD\.env"
)
if exist "sipii-api\.env\" (
    echo    - Eliminando directorio .env en sipii-api...
    rmdir /s /q "sipii-api\.env"
)
echo.

REM Iniciar servicios con Docker Compose
echo 🚀 Iniciando servicios Docker...
echo    (Esto puede tardar unos minutos la primera vez)
echo.
docker-compose up -d --build

if %errorlevel% neq 0 (
    echo.
    echo ❌ ERROR: Falló al iniciar los servicios
    echo    Revisa los logs con: docker-compose logs
    echo.
    pause
    exit /b 1
)

echo.
echo ========================================
echo ✅ Servicios Docker iniciados
echo ========================================
echo.
echo 🌐 URLs disponibles:
echo    Panel Web:  http://localhost:8000
echo    API REST:   http://localhost:8001
echo    pgAdmin:    http://localhost:5050
echo.
echo 🔑 Credenciales pgAdmin:
echo    Email:    admin@sipii.com
echo    Password: admin
echo.
echo 👤 Usuarios de prueba:
echo    Administrador: admin@sipii.com / admin123
echo    Voluntario:    voluntario@sipii.com / voluntario123
echo.
echo ========================================
echo.
echo 📋 Comandos útiles:
echo    Ver logs:         docker-compose logs -f
echo    Detener:          docker-compose stop
echo    Reiniciar:        docker-compose restart
echo    Eliminar todo:    docker-compose down -v
echo.
echo 💡 Ejecuta seeders (primera vez):
echo    docker-compose exec app php artisan db:seed --force
echo.
echo ========================================
echo.
pause
