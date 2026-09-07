<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/alumnos.php';

if (!alumno_autenticado()) {
    http_response_code(403);
    exit('Necesitas entrar con la clave de acceso de Alumnos para descargar esto.');
}

$clave = (string) ($_GET['f'] ?? '');
if (!isset(ALUMNOS_DOCUMENTOS[$clave])) {
    http_response_code(404);
    exit('Documento no encontrado.');
}

$doc = ALUMNOS_DOCUMENTOS[$clave];
// UPLOADS_PATH ya es .../php/uploads -- 'ruta' siempre empieza en alumnos/,
// nunca se arma con nada que venga del usuario más que la clave de la lista blanca.
$rutaCompleta = UPLOADS_PATH . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $doc['ruta']);

if (!is_file($rutaCompleta)) {
    http_response_code(404);
    exit('Documento no encontrado en el servidor.');
}

header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="' . addslashes($doc['nombre']) . '"');
header('Content-Length: ' . filesize($rutaCompleta));
header('X-Content-Type-Options: nosniff');
readfile($rutaCompleta);
exit;
