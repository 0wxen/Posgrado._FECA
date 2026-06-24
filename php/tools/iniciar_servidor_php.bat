@echo off
title Servidor DEP FECA UJED
cd /d "%~dp0"

echo.
echo ============================================================
echo   Servidor DEP FECA UJED  -  http://127.0.0.1:8001
echo ============================================================
echo.

REM ─────────────────────────────────────────────────────────────
REM  CONFIGURA TUS CREDENCIALES AQUI (solo para desarrollo local)
REM  En produccion usa variables del sistema o un .env real.
REM ─────────────────────────────────────────────────────────────

set PGHOST=127.0.0.1
set PGPORT=5432
set PGDATABASE=posgrado_feca

REM Usuario de PostgreSQL (usualmente "postgres")
set PGUSER=postgres

REM CONTRASENA de PostgreSQL - cambia esto por la tuya
set /p PGPASSWORD="Contrasena PostgreSQL: "

echo.
echo Sitio publico   : http://127.0.0.1:8001/html/htmlcode.html
echo Panel admin     : http://127.0.0.1:8001/php/admin/login.php
echo Probar conexion : http://127.0.0.1:8001/php/tools/probar_conexion.php
echo.
echo Primera vez? Crea el admin con:
echo   C:\xampp\php\php.exe php/tools/setup_admin.php
echo.
echo Deja esta ventana abierta. Para detener: Ctrl+C
echo.

C:\xampp\php\php.exe -S 127.0.0.1:8001 -t "%~dp0..\.."
pause
