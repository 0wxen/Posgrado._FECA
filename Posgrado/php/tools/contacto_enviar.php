<?php
declare(strict_types=1);

// receptor del formulario de contacto. Sin tabla de mensajes a propósito --
// se envía por mail() a Coordinación General. En XAMPP/Windows, mail()
// necesita SMTP configurado en php.ini o no entrega nada.

const CONTACTO_DESTINO = 'posgradofeca@ujed.mx';

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
    header('Location: /html/htmlcode.html?error=campos#contacto');
    exit;
}

$asuntoCorreo = '[Contacto Posgrado FECA] ' . $asunto . ($programa ? " ($programa)" : '');

$cuerpo  = "Nuevo mensaje desde el formulario de contacto del sitio.\r\n\r\n";
$cuerpo .= "Nombre: {$nombre}\r\n";
$cuerpo .= "Correo: {$email}\r\n";
$cuerpo .= 'Programa de interés: ' . ($programa ?: '(no especificado)') . "\r\n\r\n";
$cuerpo .= "Mensaje:\r\n{$mensaje}\r\n";

// From del propio servidor (muchos SMTP rechazan From con correo ajeno);
// Reply-To lleva al visitante para poder responderle directo.
$cabeceras = "From: Sitio Posgrado FECA <no-reply@posgradofeca.local>\r\n";
$cabeceras .= "Reply-To: {$nombre} <{$email}>\r\n";
$cabeceras .= "MIME-Version: 1.0\r\n";
$cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

$enviado = @mail(CONTACTO_DESTINO, $asuntoCorreo, $cuerpo, $cabeceras);

if ($enviado) {
    header('Location: /html/htmlcode.html?enviado=1#contacto');
} else {
    // log para no perder el mensaje si falta configurar SMTP
    error_log(sprintf(
        '[DEP-FECA] mail() falló, mensaje de contacto no entregado: %s <%s> — %s — %s',
        $nombre, $email, $asunto, mb_strimwidth($mensaje, 0, 200, '…')
    ));
    header('Location: /html/htmlcode.html?error=servidor#contacto');
}
exit;
