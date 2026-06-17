<?php
declare(strict_types=1);

$dbHost = getenv('PGHOST') ?: 'localhost';
$dbPort = getenv('PGPORT') ?: '5432';
$dbName = getenv('PGDATABASE') ?: 'posgrado_Feca';
$dbUser = getenv('PGUSER') ?: 'postgres';
$dbPassword = getenv('PGPASSWORD') ?: 'Owen1234';

$dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";

try {
  $pdo = new PDO($dsn, $dbUser, $dbPassword, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
  $pdo->exec("SET NAMES 'UTF8'");
} catch (PDOException $exception) {
  http_response_code(500);
  exit('No se pudo conectar con la base de datos.');
}
