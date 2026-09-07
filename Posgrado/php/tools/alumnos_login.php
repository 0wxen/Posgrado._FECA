<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/alumnos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /html/htmlcode.html#alumnos');
    exit;
}

$clave = trim((string) ($_POST['clave'] ?? ''));

if (intentar_acceso_alumno($clave)) {
    header('Location: /html/htmlcode.html#alumnos');
} else {
    header('Location: /html/htmlcode.html?error=clave#alumnos');
}
exit;
