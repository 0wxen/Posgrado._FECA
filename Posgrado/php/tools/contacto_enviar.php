<?php
declare(strict_types=1);

/**
 * Receptor del formulario de contacto público (POST desde contacto.php).
 * No hay tabla de mensajes (se quitó a propósito para mantener la BD
 * simple) -- en su lugar, el mensaje se envía por correo a Coordinación
 * General con mail(). En XAMPP/Windows, mail() necesita un servidor SMTP
 * configurado en php.ini (sección [mail function], sendmail_path o
 * SMTP=/smtp_port=) para entregar correos de verdad; sin eso, esta
 * función normalmente devuelve error o no entrega nada.
 */

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

// El From debe ser del propio dominio/servidor (muchos relés SMTP rechazan
// o marcan como spam un From con el correo del visitante); para responder
// directo al visitante se usa Reply-To en su lugar.
$cabeceras = "From: Sitio Posgrado FECA <no-reply@posgradofeca.local>\r\n";
$cabeceras .= "Reply-To: {$nombre} <{$email}>\r\n";
$cabeceras .= "MIME-Version: 1.0\r\n";
$cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

$enviado = @mail(CONTACTO_DESTINO, $asuntoCorreo, $cuerpo, $cabeceras);

if ($enviado) {
    header('Location: /html/htmlcode.html?enviado=1#contacto');
} else {
    // Queda en el log del servidor para no perder el mensaje aunque el
    // correo no se haya podido entregar (típico si falta configurar SMTP).
    error_log(sprintf(
        '[DEP-FECA] mail() falló, mensaje de contacto no entregado: %s <%s> — %s — %s',
        $nombre, $email, $asunto, mb_strimwidth($mensaje, 0, 200, '…')
    ));
    header('Location: /html/htmlcode.html?error=servidor#contacto');
}
exit;
