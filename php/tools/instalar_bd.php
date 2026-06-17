<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

$schemaPath = __DIR__ . '/../database/schema.sql';
$schema = file_get_contents($schemaPath);

if ($schema === false) {
  http_response_code(500);
  exit('No se pudo leer database/schema.sql');
}

$pdo->exec($schema);

echo "Base de datos actualizada correctamente.\n";
