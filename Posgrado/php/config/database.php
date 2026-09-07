<?php
declare(strict_types=1);

// PGSSLMODE solo se define en producción (Render); ahí se ocultan errores de
// PHP en pantalla (rutas, stack traces) y se dejan solo en el log del server.
// Local no lo define -- sigue mostrando errores igual que siempre para depurar.
$esProduccion = getenv('PGSSLMODE') !== false;
ini_set('display_errors', $esProduccion ? '0' : '1');
ini_set('display_startup_errors', $esProduccion ? '0' : '1');
error_reporting(E_ALL);

$dbHost = getenv('PGHOST')     ?: '127.0.0.1';
$dbPort = getenv('PGPORT')     ?: '5432';
$dbName = getenv('PGDATABASE') ?: 'FECA';
$dbUser = getenv('PGUSER')     ?: 'postgres';
$dbPass = getenv('PGPASSWORD') ?: '';
$dbSslMode = getenv('PGSSLMODE') ?: ''; // Render (y otros hosts gestionados) exigen 'require'; local no lo necesita.

// La conexión es opcional: si no hay BD el sitio muestra contenido estático.
$pdo = null;

if ($dbPass !== '') {
    // connect_timeout: con php -S (una petición a la vez) un Postgres caído
    // sin esto deja el sitio entero trabado, no solo la página que falló.
    $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s;connect_timeout=3', $dbHost, $dbPort, $dbName);
    if ($dbSslMode !== '') {
        $dsn .= ';sslmode=' . $dbSslMode;
    }
    try {
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
        $pdo->exec("SET client_encoding = 'UTF8'");
        $pdo->exec("SET timezone = 'America/Monterrey'");
        $pdo->exec("SET search_path TO posgrado, public");
    } catch (PDOException $e) {
        error_log('[DEP-FECA] Error de conexión BD: ' . $e->getMessage());
        $pdo = null;
    }
}
