<?php
declare(strict_types=1);

/**
 * REST API · DEP FECA UJED · v1
 * ─────────────────────────────────────────────────────────────
 * Endpoints públicos (GET):
 *   /php/api/v1/index.php?r=programas
 *   /php/api/v1/index.php?r=noticias
 *   /php/api/v1/index.php?r=noticias&id=5
 *   /php/api/v1/index.php?r=convocatorias
 *   /php/api/v1/index.php?r=publicaciones
 *   /php/api/v1/index.php?r=profesores
 *
 * Endpoints protegidos (requieren Bearer token):
 *   GET  /php/api/v1/index.php?r=mensajes
 *
 * Endpoints de escritura:
 *   POST /php/api/v1/index.php?r=contacto   (cuerpo JSON)
 *
 * Autenticación API:
 *   Header: Authorization: Bearer <token>
 *   Crear tokens en php/tools/setup_admin.php (modo interactivo)
 * ─────────────────────────────────────────────────────────────
 */

// Cabeceras CORS y tipo de respuesta
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

// ─────────────────────────────────────────────────────────────
// Helpers
// ─────────────────────────────────────────────────────────────

function api_ok(mixed $data, int $status = 200): never {
    http_response_code($status);
    echo json_encode(
        ['ok' => true, 'data' => $data],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    exit;
}

function api_error(string $message, int $status = 400): never {
    http_response_code($status);
    echo json_encode(['ok' => false, 'error' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

function verificar_token(): void {
    global $pdo;
    $auth  = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    $token = '';
    if (str_starts_with($auth, 'Bearer ')) {
        $token = substr($auth, 7);
    }
    if ($token === '') {
        api_error('Se requiere token de autenticación.', 401);
    }
    $hash = hash('sha256', $token);
    $stmt = $pdo->prepare(
        'SELECT id FROM api_tokens
         WHERE  token_hash = ? AND activo = TRUE
           AND  (expira_en IS NULL OR expira_en > NOW())
         LIMIT  1'
    );
    $stmt->execute([$hash]);
    if (!$stmt->fetch()) {
        api_error('Token inválido o expirado.', 401);
    }
    // Registrar último uso
    $pdo->prepare('UPDATE api_tokens SET ultimo_uso = NOW() WHERE token_hash = ?')
        ->execute([$hash]);
}

$metodo  = $_SERVER['REQUEST_METHOD'];
$recurso = $_GET['r'] ?? '';
$id      = isset($_GET['id']) ? (int)$_GET['id'] : null;

// ─────────────────────────────────────────────────────────────
// Router
// ─────────────────────────────────────────────────────────────

match ($recurso) {
    'programas'     => r_programas(),
    'noticias'      => r_noticias(),
    'convocatorias' => r_convocatorias(),
    'publicaciones' => r_publicaciones(),
    'profesores'    => r_profesores(),
    'contacto'      => r_contacto(),
    'mensajes'      => r_mensajes(),   // protegido
    default         => api_error('Recurso no encontrado.', 404),
};

// ─────────────────────────────────────────────────────────────
// PROGRAMAS  GET /api/v1/?r=programas[&nivel=maestria]
// ─────────────────────────────────────────────────────────────
function r_programas(): never {
    global $pdo, $id;

    if ($id) {
        $stmt = $pdo->prepare(
            'SELECT id, codigo, nombre, nivel, modalidad, duracion_semestres,
                    creditos, descripcion, objetivo, perfil_ingreso, perfil_egreso,
                    pnpc, pnpc_nivel
             FROM   programas WHERE id = ? AND activo = TRUE'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) api_error('Programa no encontrado.', 404);
        api_ok($row);
    }

    $nivel = $_GET['nivel'] ?? '';
    if ($nivel !== '') {
        $stmt = $pdo->prepare(
            'SELECT id, codigo, nombre, nivel, modalidad, duracion_semestres,
                    creditos, pnpc, pnpc_nivel
             FROM   programas WHERE activo = TRUE AND nivel = ?
             ORDER  BY orden_display, nombre'
        );
        $stmt->execute([$nivel]);
    } else {
        $stmt = $pdo->query(
            'SELECT id, codigo, nombre, nivel, modalidad, duracion_semestres,
                    creditos, pnpc, pnpc_nivel
             FROM   programas WHERE activo = TRUE
             ORDER  BY orden_display, nombre'
        );
    }
    api_ok($stmt->fetchAll());
}

// ─────────────────────────────────────────────────────────────
// NOTICIAS  GET /api/v1/?r=noticias[&tipo=evento&limite=10]
// ─────────────────────────────────────────────────────────────
function r_noticias(): never {
    global $pdo, $id;

    if ($id) {
        $stmt = $pdo->prepare(
            'SELECT n.*, a.ruta_relativa AS imagen_url, a.alt_texto
             FROM   noticias n
             LEFT   JOIN archivos a ON a.id = n.imagen_portada_id
             WHERE  n.id = ? AND n.es_publicado = TRUE'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) api_error('Noticia no encontrada.', 404);
        api_ok($row);
    }

    $tipo   = $_GET['tipo']   ?? '';
    $limite = min((int)($_GET['limite'] ?? 20), 100);

    $where = 'WHERE n.es_publicado = TRUE';
    $params = [];
    if ($tipo !== '') {
        $where .= ' AND n.tipo = ?';
        $params[] = $tipo;
    }

    $params[] = $limite;
    $stmt = $pdo->prepare(
        "SELECT n.id, n.tipo, n.titulo, n.slug, n.resumen, n.es_destacado,
                n.publicado_en, n.fecha_evento, n.lugar_evento,
                a.ruta_relativa AS imagen_url, a.alt_texto
         FROM   noticias n
         LEFT   JOIN archivos a ON a.id = n.imagen_portada_id
         $where
         ORDER  BY n.es_destacado DESC, n.publicado_en DESC NULLS LAST
         LIMIT  ?"
    );
    $stmt->execute($params);
    api_ok($stmt->fetchAll());
}

// ─────────────────────────────────────────────────────────────
// CONVOCATORIAS  GET /api/v1/?r=convocatorias[&vigentes=1]
// ─────────────────────────────────────────────────────────────
function r_convocatorias(): never {
    global $pdo;

    $vigentes = ($_GET['vigentes'] ?? '0') === '1';
    $where    = 'WHERE c.es_publicado = TRUE';
    if ($vigentes) {
        $where .= ' AND (c.fecha_cierre IS NULL OR c.fecha_cierre >= CURRENT_DATE)';
    }

    $stmt = $pdo->query(
        "SELECT c.id, c.titulo, c.descripcion, c.ciclo,
                c.fecha_inicio, c.fecha_cierre, c.fecha_inicio_clases,
                p.codigo AS programa_codigo, p.nombre AS programa_nombre,
                af.ruta_relativa AS archivo_url,
                ap.ruta_relativa AS poster_url
         FROM   convocatorias c
         LEFT   JOIN programas p  ON p.id  = c.programa_id
         LEFT   JOIN archivos  af ON af.id = c.archivo_id
         LEFT   JOIN archivos  ap ON ap.id = c.imagen_poster_id
         $where
         ORDER  BY c.fecha_cierre ASC NULLS LAST, c.creado_en DESC"
    );
    api_ok($stmt->fetchAll());
}

// ─────────────────────────────────────────────────────────────
// PUBLICACIONES  GET /api/v1/?r=publicaciones[&tipo=articulo&anio=2024]
// ─────────────────────────────────────────────────────────────
function r_publicaciones(): never {
    global $pdo;

    $tipo   = $_GET['tipo']   ?? '';
    $anio   = isset($_GET['anio']) ? (int)$_GET['anio'] : null;
    $limite = min((int)($_GET['limite'] ?? 20), 100);

    $where  = 'WHERE p.es_publicado = TRUE';
    $params = [];

    if ($tipo !== '') { $where .= ' AND p.tipo = ?'; $params[] = $tipo; }
    if ($anio)        { $where .= ' AND p.anio = ?'; $params[] = $anio; }
    $params[] = $limite;

    $stmt = $pdo->prepare(
        "SELECT p.id, p.tipo, p.titulo, p.autores_texto, p.anio,
                p.revista_editorial, p.doi, p.url_externo, p.resumen,
                a.ruta_relativa AS archivo_url
         FROM   publicaciones p
         LEFT   JOIN archivos a ON a.id = p.archivo_id
         $where
         ORDER  BY p.anio DESC, p.titulo
         LIMIT  ?"
    );
    $stmt->execute($params);
    api_ok($stmt->fetchAll());
}

// ─────────────────────────────────────────────────────────────
// PROFESORES  GET /api/v1/?r=profesores
// ─────────────────────────────────────────────────────────────
function r_profesores(): never {
    global $pdo;

    $stmt = $pdo->query(
        'SELECT p.id, p.nombre, p.grado_academico, p.titulo_cargo,
                p.especialidad, p.sni_nivel, p.orcid,
                a.ruta_relativa AS foto_url
         FROM   profesores p
         LEFT   JOIN archivos a ON a.id = p.foto_id
         WHERE  p.activo = TRUE
         ORDER  BY p.orden_display, p.nombre'
    );
    api_ok($stmt->fetchAll());
}

// ─────────────────────────────────────────────────────────────
// CONTACTO  POST /api/v1/?r=contacto
// Body JSON: { nombre, email, asunto, mensaje, programa_interes? }
// ─────────────────────────────────────────────────────────────
function r_contacto(): never {
    global $pdo, $metodo;

    if ($metodo !== 'POST') api_error('Método no permitido.', 405);

    $body = json_decode(file_get_contents('php://input'), true);
    if (!is_array($body)) api_error('Cuerpo JSON inválido.');

    $nombre  = trim($body['nombre']  ?? '');
    $email   = trim($body['email']   ?? '');
    $asunto  = trim($body['asunto']  ?? '');
    $mensaje = trim($body['mensaje'] ?? '');

    if ($nombre === '' || $email === '' || $asunto === '' || $mensaje === '') {
        api_error('Campos obligatorios: nombre, email, asunto, mensaje.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        api_error('El correo electrónico no es válido.');
    }
    if (strlen($mensaje) > 5000) {
        api_error('El mensaje no puede superar los 5,000 caracteres.');
    }

    $stmt = $pdo->prepare(
        'INSERT INTO mensajes_contacto (nombre, email, asunto, programa_interes, mensaje, ip_origen)
         VALUES (?, ?, ?, ?, ?, ?::inet)'
    );
    $stmt->execute([
        $nombre,
        $email,
        substr($asunto, 0, 100),
        $body['programa_interes'] ?? null,
        $mensaje,
        $_SERVER['REMOTE_ADDR'] ?? null,
    ]);

    api_ok(['mensaje' => 'Mensaje recibido. Te responderemos en un plazo de 2 días hábiles.'], 201);
}

// ─────────────────────────────────────────────────────────────
// MENSAJES  GET /api/v1/?r=mensajes  (requiere Bearer token)
// ─────────────────────────────────────────────────────────────
function r_mensajes(): never {
    global $pdo;

    verificar_token();

    $stmt = $pdo->query(
        'SELECT id, nombre, email, asunto, programa_interes,
                substring(mensaje, 1, 200) AS mensaje_preview,
                leido, respondido, creado_en
         FROM   mensajes_contacto
         ORDER  BY creado_en DESC
         LIMIT  100'
    );
    api_ok($stmt->fetchAll());
}
