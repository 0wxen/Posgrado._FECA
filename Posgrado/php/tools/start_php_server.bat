@echo off
title Servidor DEP FECA UJED
cd /d "%~dp0"

echo.
echo ============================================================
echo   Servidor DEP FECA UJED  -  http://127.0.0.1:8001
echo ============================================================
echo.

REM ─────────────────────────────────────────────────────────────
REM  Buscar PHP en ubicaciones comunes
REM ─────────────────────────────────────────────────────────────
set PHP=
if exist "C:\xampp\php\php.exe"              set PHP=C:\xampp\php\php.exe
if "%PHP%"=="" if exist "C:\php\php.exe"     set PHP=C:\php\php.exe
if "%PHP%"=="" if exist "C:\php8\php.exe"    set PHP=C:\php8\php.exe
if "%PHP%"=="" if exist "C:\php7\php.exe"    set PHP=C:\php7\php.exe
if "%PHP%"=="" for /f "tokens=*" %%i in ('where php 2^>nul') do if "%PHP%"=="" set PHP=%%i

if "%PHP%"=="" (
    echo ERROR: No se encontro PHP en tu sistema.
    echo.
    echo Opciones:
    echo   1. Instala XAMPP desde https://www.apachefriends.org/
    echo   2. Instala PHP y agrega su carpeta al PATH de Windows
    echo.
    echo El sitio sigue funcionando en Live Server sin este servidor
    echo usando las paginas estaticas en Posgrado/pages/
    echo.
    pause
    exit /b 1
)

echo PHP: %PHP%
echo.

REM ─────────────────────────────────────────────────────────────
REM  CREDENCIALES DE BASE DE DATOS
REM  Si existe php/.env (PGHOST/PGPORT/PGDATABASE/PGUSER/PGPASSWORD,
REM  un renglon por variable) se cargan de ahi sin preguntar nada.
REM  Si no existe, se piden por teclado (Enter para omitir BD).
REM ─────────────────────────────────────────────────────────────
set PGHOST=127.0.0.1
set PGPORT=5432
set PGDATABASE=FECA
set PGUSER=postgres
set PGPASSWORD=

if exist "%~dp0..\.env" (
    echo Cargando credenciales desde php\.env
    for /f "usebackq tokens=1,* delims==" %%A in ("%~dp0..\.env") do set %%A=%%B
) else (
    set /p PGDATABASE="Nombre de la base de datos [FECA]: "
    set /p PGPASSWORD="Contrasena PostgreSQL (Enter para omitir BD): "
)

echo.
echo Sitio principal : http://127.0.0.1:8001/html/htmlcode.html
echo Panel admin     : http://127.0.0.1:8001/php/admin/login.php
echo.
echo Deja esta ventana abierta. Para detener: Ctrl+C
echo.

"%PHP%" -S 127.0.0.1:8001 -t "%~dp0..\.." "%~dp0router.php"
pause
