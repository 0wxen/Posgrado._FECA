<?php
declare(strict_types=1);

/**
 * REST API · DEP FECA UJED · v1
 * Endpoints públicos (GET): ?r=programas | blog | blog&id=5 | convocatorias
 * | publicaciones | profesores
 */

header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// preflight CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

// helpers
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

$recurso = $_GET['r'] ?? '';
$id      = isset($_GET['id']) ? (int)$_GET['id'] : null;

// router
match ($recurso) {
    'programas'     => r_programas(),
    'blog'          => r_blog(),
    'convocatorias' => r_convocatorias(),
    'publicaciones' => r_publicaciones(),
    'profesores'    => r_profesores(),
    default         => api_error('Recurso no encontrado.', 404),
};

// programas: ?r=programas[&nivel=maestria]
function r_programas(): never {
    global $pdo, $id;

    if ($id) {
        $stmt = $pdo->prepare(
            'SELECT id, codigo, nombre, nivel, modalidad, duracion_semestres,
                    creditos, descripcion, objetivo, perfil_ingreso, perfil_egreso
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
            'SELECT id, codigo, nombre, nivel, modalidad, duracion_semestres, creditos
             FROM   programas WHERE activo = TRUE AND nivel = ?
             ORDER  BY orden_display, nombre'
        );
        $stmt->execute([$nivel]);
    } else {
        $stmt = $pdo->query(
            'SELECT id, codigo, nombre, nivel, modalidad, duracion_semestres, creditos
             FROM   programas WHERE activo = TRUE
             ORDER  BY orden_display, nombre'
        );
    }
    api_ok($stmt->fetchAll());
}

// blog: ?r=blog[&limite=10]
function r_blog(): never {
    global $pdo, $id;

    if ($id) {
        $stmt = $pdo->prepare(
            'SELECT b.*, a.ruta_relativa AS imagen_url, a.alt_texto
             FROM   blog b
             LEFT   JOIN archivos a ON a.id = b.imagen_id
             WHERE  b.id = ? AND b.es_publicado = TRUE'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) api_error('Entrada no encontrada.', 404);
        api_ok($row);
    }

    $limite = min((int)($_GET['limite'] ?? 20), 100);
    $stmt = $pdo->prepare(
        'SELECT b.id, b.titulo, b.slug, b.resumen, b.destacado,
                b.publicado_en, b.fecha_evento, b.lugar_evento,
                a.ruta_relativa AS imagen_url, a.alt_texto
         FROM   blog b
         LEFT   JOIN archivos a ON a.id = b.imagen_id
         WHERE  b.es_publicado = TRUE
         ORDER  BY b.destacado DESC, b.publicado_en DESC NULLS LAST
         LIMIT  ?'
    );
    $stmt->bindValue(1, $limite, PDO::PARAM_INT);
    $stmt->execute();
    api_ok($stmt->fetchAll());
}

// convocatorias: ?r=convocatorias[&vigentes=1]
function r_convocatorias(): never {
    global $pdo;

    $vigentes = ($_GET['vigentes'] ?? '0') === '1';
    $where    = 'WHERE c.es_publicado = TRUE';
    if ($vigentes) {
        $where .= ' AND (c.fecha_cierre IS NULL OR c.fecha_cierre >= CURRENT_DATE)';
    }

    $stmt = $pdo->query(
        "SELECT c.id, c.titulo, c.descripcion, c.ciclo,
                c.fecha_inicio, c.fecha_cierre, c.destacado,
                p.codigo AS programa_codigo, p.nombre AS programa_nombre,
                af.ruta_relativa AS archivo_url,
                ap.ruta_relativa AS imagen_url
         FROM   convocatorias c
         LEFT   JOIN programas p  ON p.id  = c.programa_id
         LEFT   JOIN archivos  af ON af.id = c.archivo_id
         LEFT   JOIN archivos  ap ON ap.id = c.imagen_id
         $where
         ORDER  BY c.fecha_cierre ASC NULLS LAST, c.creado_en DESC"
    );
    api_ok($stmt->fetchAll());
}

// publicaciones: ?r=publicaciones[&tipo=articulo&anio=2024]
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
         ORDER  BY p.anio DESC NULLS LAST, p.titulo
         LIMIT  ?"
    );
    $stmt->execute($params);
    api_ok($stmt->fetchAll());
}

// profesores: ?r=profesores
function r_profesores(): never {
    global $pdo;

    $stmt = $pdo->query(
        'SELECT p.id, p.nombre, p.grado_academico, p.titulo_cargo,
                p.especialidad, p.orcid, p.google_scholar_url,
                a.ruta_relativa AS foto_url
         FROM   profesores p
         LEFT   JOIN archivos a ON a.id = p.foto_id
         WHERE  p.activo = TRUE
         ORDER  BY p.orden_display, p.nombre'
    );
    api_ok($stmt->fetchAll());
}
