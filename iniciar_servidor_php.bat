@echo off
cd /d "%~dp0"
echo Servidor PHP iniciado en:
echo http://127.0.0.1:8001/php/probar_conexion.php
echo.
echo Deja esta ventana abierta mientras usas la pagina.
echo Para detener el servidor presiona Ctrl+C.
echo.
C:\xampp\php\php.exe -S 127.0.0.1:8001 -t "%~dp0"
pause
