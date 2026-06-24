<?php
declare(strict_types=1);

// Credenciales desde variables de entorno ÚNICAMENTE.
// Configúralas antes de iniciar el servidor (ver iniciar_servidor_php.bat).
$dbHost = getenv('PGHOST')     ?: '127.0.0.1';
$dbPort = getenv('PGPORT')     ?: '5432';
$dbName = getenv('PGDATABASE') ?: 'posgrado_feca';
$dbUser = getenv('PGUSER')     ?: 'postgres';
$dbPass = getenv('PGPASSWORD');

if ($dbPass === false || $dbPass === '') {
    $esDev = ($_SERVER['SERVER_NAME'] ?? 'localhost') === 'localhost' ||
             ($_SERVER['SERVER_ADDR'] ?? '127.0.0.1') === '127.0.0.1';
    if (!$esDev) {
        http_response_code(500);
        error_log('[DEP-FECA] Variable PGPASSWORD no configurada.');
        exit('Error de configuración del servidor.');
    }
    // Solo en desarrollo local muestra el error detallado
    http_response_code(500);
    exit('Configura la variable de entorno PGPASSWORD antes de iniciar el servidor. ' .
         'Edita iniciar_servidor_php.bat o define la variable en tu sistema.');
}

$dsn = sprintf(
    'pgsql:host=%s;port=%s;dbname=%s',
    $dbHost, $dbPort, $dbName
);

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,  // prepared statements reales
    ]);
    $pdo->exec("SET client_encoding = 'UTF8'");
    $pdo->exec("SET timezone = 'America/Monterrey'");
} catch (PDOException $e) {
    http_response_code(500);
    error_log('[DEP-FECA] Error de conexión BD: ' . $e->getMessage());
    exit('No se pudo conectar con la base de datos.');
}
