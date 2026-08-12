<?php
// router de php -S: CORS para que Live Server (5500) haga fetch al PHP (8001)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit(0);
}

// Retornar false le dice al servidor PHP que procese el archivo normalmente
return false;
