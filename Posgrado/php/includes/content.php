<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function h(?string $value): string {
  return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * PDO_PGSQL devuelve las columnas BOOLEAN como los strings 't'/'f',
 * no como bool de PHP -- (bool) 'f' es TRUE, así que hay que
 * interpretarlas explícitamente en vez de castear directo.
 */
function db_bool(mixed $valor): bool {
  if (is_bool($valor)) return $valor;
  if ($valor === null) return false;
  return in_array(strtolower(trim((string) $valor)), ['t', 'true', '1', 'yes'], true);
}

/**
 * Ejecuta una consulta de listado y devuelve [] en vez de tumbar la página
 * si la tabla todavía no existe (migración pendiente) -- mismo criterio que
 * ya usa $pdo === null: si no se puede leer, se muestra vacío, no un error.
 */
function listado_seguro(callable $consulta): array {
  global $pdo;
  if ($pdo === null) return [];
  try {
    return $consulta();
  } catch (\PDOException $e) {
    error_log('[DEP-FECA] Tabla no disponible todavía: ' . $e->getMessage());
    return [];
  }
}

/**
 * Convierte una ruta_relativa de `archivos` (ej. "uploads/xxx.png", relativa
 * a la carpeta php/) en la URL que necesita el sitio público. Las páginas
 * públicas se inyectan como HTML dentro de html/htmlcode.html -- el navegador
 * resuelve las rutas relativas contra ESA URL, no contra la del script PHP
 * que las generó -- por eso hace falta el "php/" extra que no lleva la ruta
 * guardada en la BD.
 */
function url_subida(?string $rutaRelativa): string {
  if ($rutaRelativa === null || $rutaRelativa === '') return '';
  if (preg_match('#^https?://#i', $rutaRelativa) === 1) return $rutaRelativa;
  return '../php/' . ltrim($rutaRelativa, '/');
}

// ─────────────────────────────────────────────────────────────
// LISTADOS PÚBLICOS
// Todas devuelven [] si no hay conexión, para que las páginas
// puedan caer de vuelta a su contenido estático.
// ─────────────────────────────────────────────────────────────

function listar_profesores(): array {
  global $pdo;
  if ($pdo === null) return [];
  $stmt = $pdo->query(
    'SELECT p.*, a.ruta_relativa AS foto_url
     FROM profesores p
     LEFT JOIN archivos a ON a.id = p.foto_id
     WHERE p.activo = TRUE
     ORDER BY p.orden_display, p.nombre'
  );
  return $stmt->fetchAll();
}

function listar_documentos(?string $categoria = null, int $limite = 20, ?string $audiencia = null): array {
  global $pdo;
  if ($pdo === null) return [];

  $where = 'WHERE d.es_publicado = TRUE';
  $params = [];
  if ($categoria !== null) {
    $where .= ' AND d.categoria = ?';
    $params[] = $categoria;
  }
  if ($audiencia !== null) {
    $where .= " AND d.audiencia IN (?, 'todos')";
    $params[] = $audiencia;
  }
  $params[] = $limite;

  $stmt = $pdo->prepare(
    "SELECT d.*, a.ruta_relativa AS archivo_url, a.nombre_original AS archivo_nombre
     FROM documentos d
     LEFT JOIN archivos a ON a.id = d.archivo_id
     $where
     ORDER BY d.orden_display, d.creado_en DESC
     LIMIT ?"
  );
  $stmt->execute($params);
  return $stmt->fetchAll();
}

function listar_mensajes_institucionales(): array {
  global $pdo;
  return listado_seguro(fn() => $pdo->query(
    'SELECT m.*, a.ruta_relativa AS foto_url
     FROM mensajes_institucionales m
     LEFT JOIN archivos a ON a.id = m.foto_id
     ORDER BY m.orden_display'
  )->fetchAll());
}

function listar_faq(): array {
  global $pdo;
  return listado_seguro(fn() => $pdo->query(
    'SELECT * FROM preguntas_frecuentes WHERE activo = TRUE ORDER BY orden_display, id'
  )->fetchAll());
}

function listar_blog(int $limite = 10): array {
  global $pdo;
  if ($pdo === null) return [];
  $stmt = $pdo->prepare(
    'SELECT b.*, a.ruta_relativa AS imagen_url, p.nombre AS autor_nombre
     FROM blog b
     LEFT JOIN archivos a ON a.id = b.imagen_id
     LEFT JOIN profesores p ON p.id = b.autor_profesor_id
     WHERE b.es_publicado = TRUE
     ORDER BY b.destacado DESC, b.publicado_en DESC NULLS LAST
     LIMIT ?'
  );
  $stmt->bindValue(1, $limite, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll();
}

function listar_convocatorias(bool $soloVigentes = false): array {
  global $pdo;
  if ($pdo === null) return [];

  $where = 'WHERE c.es_publicado = TRUE';
  if ($soloVigentes) {
    $where .= ' AND (c.fecha_cierre IS NULL OR c.fecha_cierre >= CURRENT_DATE)';
  }

  $stmt = $pdo->query(
    "SELECT c.*, p.codigo AS programa_codigo, p.nombre AS programa_nombre,
            af.ruta_relativa AS archivo_url, ap.ruta_relativa AS imagen_url
     FROM convocatorias c
     LEFT JOIN programas p  ON p.id  = c.programa_id
     LEFT JOIN archivos  af ON af.id = c.archivo_id
     LEFT JOIN archivos  ap ON ap.id = c.imagen_id
     $where
     ORDER BY c.destacado DESC, c.fecha_cierre ASC NULLS LAST, c.creado_en DESC"
  );
  return $stmt->fetchAll();
}

function listar_programas(): array {
  global $pdo;
  if ($pdo === null) return [];
  $stmt = $pdo->query(
    'SELECT p.*, a.ruta_relativa AS imagen_url
     FROM programas p
     LEFT JOIN archivos a ON a.id = p.imagen_id
     WHERE p.activo = TRUE
     ORDER BY p.orden_display, p.nombre'
  );
  return $stmt->fetchAll();
}

function obtener_programa_por_codigo(string $codigo): ?array {
  global $pdo;
  if ($pdo === null) return null;
  $stmt = $pdo->prepare(
    'SELECT p.*, a.ruta_relativa AS imagen_url
     FROM programas p
     LEFT JOIN archivos a ON a.id = p.imagen_id
     WHERE p.codigo = :codigo AND p.activo = TRUE'
  );
  $stmt->execute(['codigo' => $codigo]);
  $fila = $stmt->fetch();
  return $fila !== false ? $fila : null;
}

function listar_titulacion_programa(int $programaId): array {
  global $pdo;
  return listado_seguro(function () use ($pdo, $programaId) {
    $stmt = $pdo->prepare('SELECT * FROM programa_titulacion WHERE programa_id = :id ORDER BY orden_display, id');
    $stmt->execute(['id' => $programaId]);
    return $stmt->fetchAll();
  });
}

function listar_campo_laboral_programa(int $programaId): array {
  global $pdo;
  return listado_seguro(function () use ($pdo, $programaId) {
    $stmt = $pdo->prepare('SELECT * FROM programa_campo_laboral WHERE programa_id = :id ORDER BY orden_display, id');
    $stmt->execute(['id' => $programaId]);
    return $stmt->fetchAll();
  });
}

function listar_publicaciones(int $limite = 20): array {
  global $pdo;
  if ($pdo === null) return [];
  $stmt = $pdo->prepare(
    'SELECT pb.*, a.ruta_relativa AS archivo_url
     FROM publicaciones pb
     LEFT JOIN archivos a ON a.id = pb.archivo_id
     WHERE pb.es_publicado = TRUE
     ORDER BY pb.anio DESC NULLS LAST, pb.titulo
     LIMIT ?'
  );
  $stmt->bindValue(1, $limite, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll();
}

function listar_grupos_disciplinares(): array {
  global $pdo;
  if ($pdo === null) return [];
  $stmt = $pdo->query(
    'SELECT * FROM grupos_disciplinares
     WHERE activo = TRUE
     ORDER BY nombre'
  );
  return $stmt->fetchAll();
}

/**
 * Imágenes de secciones fijas (galería de Inicio, organigrama de Nosotros),
 * indexadas por clave. Devuelve solo las que ya tienen un archivo asignado.
 */
function listar_imagenes_sitio(): array {
  global $pdo;
  if ($pdo === null) return [];
  $stmt = $pdo->query(
    'SELECT i.clave, a.ruta_relativa AS imagen_url, a.alt_texto
     FROM imagenes_sitio i
     JOIN archivos a ON a.id = i.imagen_id'
  );
  $porClave = [];
  foreach ($stmt->fetchAll() as $fila) {
    $porClave[$fila['clave']] = $fila;
  }
  return $porClave;
}
?>
