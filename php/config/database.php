<?php
declare(strict_types=1);

$dbHost = getenv('PGHOST') ?: 'localhost';
$dbPort = getenv('PGPORT') ?: '5432';
$dbName = getenv('PGDATABASE') ?: 'posgrado_feca';
$dbUser = getenv('PGUSER') ?: 'postgres';
$dbPassword = getenv('PGPASSWORD') ?: '';

$dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";

try {
  $pdo = new PDO($dsn, $dbUser, $dbPassword, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
} catch (PDOException $exception) {
  http_response_code(500);
  exit('No se pudo conectar con la base de datos.');
}
