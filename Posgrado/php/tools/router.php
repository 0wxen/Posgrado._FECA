<?php
// Router para php -S: agrega cabeceras CORS en desarrollo local
// Permite que Live Server (puerto 5500) pueda hacer fetch al servidor PHP (8001)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit(0);
}

// Retornar false le dice al servidor PHP que procese el archivo normalmente
return false;
