@echo off
chcp 65001 > nul
cls
echo ========================================
echo 🛑 SIPII - Deteniendo Docker
echo ========================================
echo.

REM Verificar si Docker está instalado
docker --version > nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ ERROR: Docker no está instalado o no está en el PATH
    echo.
    pause
    exit /b 1
)

echo 🛑 Deteniendo servicios Docker...
echo.
docker-compose stop

if %errorlevel% neq 0 (
    echo.
    echo ❌ ERROR: Falló al detener los servicios
    echo.
    pause
    exit /b 1
)

echo.
echo ========================================
echo ✅ Servicios detenidos
echo ========================================
echo.
echo Los contenedores están detenidos pero no eliminados.
echo Los datos se mantienen en los volúmenes.
echo.
echo Para iniciar nuevamente: INICIAR-DOCKER.bat
echo Para eliminar todo:      docker-compose down -v
echo.
pause
