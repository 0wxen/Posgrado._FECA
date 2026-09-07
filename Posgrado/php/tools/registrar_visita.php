<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

// cargar.js llama esto (fetch, sin esperar respuesta) cada vez que carga una
// sección del sitio público. Un solo UPSERT por visita, nunca una fila nueva
// -- el conteo real vive aquí, no en localStorage del navegador de quien mira
// el panel.
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $pdo === null) {
    http_response_code(204);
    exit;
}

$pagina = trim((string) ($_POST['pagina'] ?? ''));
if ($pagina === '' || !preg_match('/^[a-z0-9_]{1,60}$/', $pagina)) {
    http_response_code(204);
    exit;
}

try {
    $pdo->prepare(
        'INSERT INTO estadisticas_visitas (pagina, visitas, actualizado_en)
         VALUES (:p, 1, NOW())
         ON CONFLICT (pagina) DO UPDATE
         SET visitas = estadisticas_visitas.visitas + 1, actualizado_en = NOW()'
    )->execute(['p' => $pagina]);
} catch (\PDOException $e) {
    error_log('[DEP-FECA] registrar_visita: ' . $e->getMessage());
}

http_response_code(204);
exit;
