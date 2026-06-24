<?php
declare(strict_types=1);

/**
 * Receptor del formulario de contacto público (POST desde contacto.php).
 * Guarda el mensaje en mensajes_contacto y redirige de vuelta al sitio.
 */

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /html/htmlcode.html#contacto');
    exit;
}

$nombre   = trim($_POST['nombre']   ?? '');
$email    = trim($_POST['email']    ?? '');
$asunto   = trim($_POST['asunto']   ?? '');
$programa = trim($_POST['programa'] ?? '') ?: null;
$mensaje  = trim($_POST['mensaje']  ?? '');

$errores = [];
if ($nombre  === '') $errores[] = 'nombre';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'email';
if ($asunto  === '') $errores[] = 'asunto';
if ($mensaje === '') $errores[] = 'mensaje';

if (!empty($errores)) {
    header('Location: /html/htmlcode.html#contacto?error=campos');
    exit;
}

try {
    $stmt = $pdo->prepare(
        'INSERT INTO mensajes_contacto (nombre, email, asunto, programa_interes, mensaje, ip_origen)
         VALUES (?, ?, ?, ?, ?, ?::inet)'
    );
    $stmt->execute([
        substr($nombre,  0, 200),
        substr($email,   0, 180),
        substr($asunto,  0, 100),
        $programa ? substr($programa, 0, 10) : null,
        substr($mensaje, 0, 5000),
        $_SERVER['REMOTE_ADDR'] ?? null,
    ]);

    header('Location: /html/htmlcode.html#contacto?enviado=1');
} catch (PDOException $e) {
    error_log('[DEP-FECA] Error guardando mensaje: ' . $e->getMessage());
    header('Location: /html/htmlcode.html#contacto?error=servidor');
}

exit;
