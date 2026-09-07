<?php
declare(strict_types=1);

// ejecuta schema.sql completo -- solo por línea de comandos, nunca por HTTP
// (antes cualquiera con la URL podía recrear/alterar la BD en producción).
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Este script solo se ejecuta desde la línea de comandos.\n");
}

require_once __DIR__ . '/../config/database.php';

$schemaPath = __DIR__ . '/../database/schema.sql';
$schema = file_get_contents($schemaPath);

if ($schema === false) {
  http_response_code(500);
  exit('No se pudo leer database/schema.sql');
}

$pdo->exec($schema);

echo "Base de datos actualizada correctamente.\n";
