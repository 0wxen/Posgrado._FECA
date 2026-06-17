<?php
declare(strict_types=1);

require_once __DIR__ . '/config/database.php';

// Compatibilidad con archivos existentes que esperan la variable $conexion.
$conexion = $pdo;
