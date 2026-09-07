<?php
// router de php -S: CORS para que Live Server (5500) haga fetch al PHP (8001)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

// headers de seguridad -- solo en producción (Render). Local no los pone
// para no arriesgar romper Live Server / herramientas de depuración.
if (getenv('PGSSLMODE') !== false) {
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    // frame-ancestors cubre lo mismo que X-Frame-Options (clickjacking) y ya
    // lo reemplaza en navegadores modernos. unsafe-inline en script/style
    // sigue siendo necesario -- el sitio usa <script>/style="" en línea por
    // todos lados, quitarlo sin reescribirlo todo rompería la mitad del sitio.
    header(
        "Content-Security-Policy: default-src 'self'; " .
        "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; " .
        "font-src 'self' https://fonts.gstatic.com; " .
        "img-src 'self' data:; " .
        "frame-src https://maps.google.com https://www.google.com; " .
        "connect-src 'self'; object-src 'none'; base-uri 'self'; frame-ancestors 'self';"
    );
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit(0);
}

// Retornar false le dice al servidor PHP que procese el archivo normalmente
return false;
