@echo off
echo ========================================
echo SIPII - Iniciando Servidores
echo ========================================
echo.
echo Panel Web AdminLTE: http://localhost:8000
echo API REST:           http://localhost:8001
echo.
echo Presiona Ctrl+C para detener los servidores
echo ========================================
echo.

start "SIPII Panel Web" cmd /k "cd /d C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\Laraprueba-CRUD && php artisan serve --port=8000"

timeout /t 2 /nobreak > nul

start "SIPII API" cmd /k "cd /d C:\Users\lenovo\OneDrive\Desktop\Proyectos\SIPII Laravel\Laraprueba-CRUD\sipii-api && php artisan serve --port=8001"

echo.
echo Servidores iniciados!
echo.
pause
