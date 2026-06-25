<?php
declare(strict_types=1);

$dbHost = getenv('PGHOST')     ?: '127.0.0.1';
$dbPort = getenv('PGPORT')     ?: '5432';
$dbName = getenv('PGDATABASE') ?: 'posgrado_feca';
$dbUser = getenv('PGUSER')     ?: 'postgres';
$dbPass = getenv('PGPASSWORD') ?: '';

// La conexión es opcional: si no hay BD el sitio muestra contenido estático.
$pdo = null;

if ($dbPass !== '') {
    $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $dbHost, $dbPort, $dbName);
    try {
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
        $pdo->exec("SET client_encoding = 'UTF8'");
        $pdo->exec("SET timezone = 'America/Monterrey'");
    } catch (PDOException $e) {
        error_log('[DEP-FECA] Error de conexión BD: ' . $e->getMessage());
        $pdo = null;
    }
}
