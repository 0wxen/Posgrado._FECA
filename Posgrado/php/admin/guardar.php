<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/content.php';
require_once __DIR__ . '/../includes/archivos.php';
require_once __DIR__ . '/modulos.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: panel.php');
  exit;
}

$usuarioActual = usuario_actual();
$usuarioId = (int) ($usuarioActual['id'] ?? 0);
$modulo = $_POST['modulo'] ?? '';
$accion = $_POST['accion'] ?? '';

function volver(string $tab, string $estado, string $mensaje = ''): never {
  $qs = 'tab=' . rawurlencode($tab) . '&' . $estado . '=1';
  if ($mensaje !== '') {
    $qs .= '&msg=' . rawurlencode($mensaje);
  }
  header('Location: panel.php?' . $qs);
  exit;
}

function generar_slug(string $texto): string {
  $slug = strtolower(trim($texto));
  $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug) ?: $slug;
  $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? '';
  return trim($slug, '-');
}

function sanear_html_admin(string $html): string {
  return strip_tags(
    $html,
    '<p><br><strong><em><b><i><u><ul><ol><li><a><h2><h3><h4><blockquote><img><table><thead><tbody><tr><td><th><figure><figcaption>'
  );
}

// Módulos sin pestaña propia: al guardar, regresan a la pestaña padre.
const MODULO_TAB_PADRE = [
  'titulacion'     => 'oferta',
  'campo_laboral'  => 'oferta',
  'publicaciones'  => 'investigacion',
  'faq'            => 'documentos',
];

function volverModulo(string $modulo, bool $esSubitemPrograma, ?int $idContexto, string $estado, string $mensaje = ''): never {
  if (isset(MODULO_TAB_PADRE[$modulo])) {
    $qs = 'tab=' . MODULO_TAB_PADRE[$modulo];
    if ($esSubitemPrograma && $idContexto) {
      $qs .= '&editar=' . $idContexto;
    }
    $qs .= '&' . $estado . '=1';
    if ($mensaje !== '') $qs .= '&msg=' . rawurlencode($mensaje);
    header('Location: panel.php?' . $qs . '#sub-' . $modulo);
    exit;
  }
  volver($modulo, $estado, $mensaje);
}

try {

// imágenes del sitio (galería de Inicio, organigrama)
if ($modulo === 'imagenes') {
  $clave = trim($_POST['clave'] ?? '');
  if ($clave === '') {
    volver('imagenes', 'error', 'Falta la clave de la imagen.');
  }

  try {
    $imagenId = archivo_subir_si_viene('imagen', $usuarioId);
  } catch (RuntimeException $e) {
    volver('imagenes', 'error', $e->getMessage());
  }

  if ($imagenId === null) {
    volver('imagenes', 'error', 'Selecciona un archivo de imagen.');
  }

  $pdo->prepare('UPDATE imagenes_sitio SET imagen_id = ? WHERE clave = ?')
      ->execute([$imagenId, $clave]);

  volver('imagenes', 'ok', 'Imagen actualizada.');
}

// mensaje institucional (Director / Jefe de Posgrado en Nosotros)
if ($modulo === 'mensajes') {
  $clave = trim($_POST['clave'] ?? '');
  if (!in_array($clave, ['director', 'jefe'], true)) {
    volver('mensajes', 'error', 'Mensaje institucional no reconocido.');
  }

  $nombre = trim($_POST['nombre'] ?? '');
  $cargo = trim($_POST['cargo'] ?? '');
  $mensaje = trim($_POST['mensaje'] ?? '');

  if ($nombre === '' || $cargo === '') {
    volver('mensajes', 'error', 'Nombre y cargo son obligatorios.');
  }

  try {
    $fotoId = archivo_subir_si_viene('foto', $usuarioId);
  } catch (RuntimeException $e) {
    volver('mensajes', 'error', $e->getMessage());
  }

  if ($fotoId !== null) {
    $pdo->prepare('UPDATE mensajes_institucionales SET nombre = ?, cargo = ?, mensaje = ?, foto_id = ? WHERE clave = ?')
        ->execute([$nombre, $cargo, $mensaje, $fotoId, $clave]);
  } else {
    $pdo->prepare('UPDATE mensajes_institucionales SET nombre = ?, cargo = ?, mensaje = ? WHERE clave = ?')
        ->execute([$nombre, $cargo, $mensaje, $clave]);
  }

  volver('mensajes', 'ok', 'Mensaje institucional actualizado.');
}

// usuarios (solo control_maestro)
if ($modulo === 'usuarios') {
  require_rol('control_maestro');

  if ($accion === 'eliminar') {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id === $usuarioId) {
      volver('usuarios', 'error', 'No puedes eliminar tu propia cuenta.');
    }
    if ($id > 0) {
      $pdo->prepare('DELETE FROM usuarios WHERE id = ?')->execute([$id]);
    }
    volver('usuarios', 'ok', 'Usuario eliminado.');
  }

  $nombreCompleto = trim($_POST['nombre_completo'] ?? '');
  $nombreUsuario = trim($_POST['nombre_usuario'] ?? '');
  $contrasena = $_POST['contrasena'] ?? '';
  $rol = ($_POST['rol'] ?? '') === 'control_maestro' ? 'control_maestro' : 'administrador';
  $activo = isset($_POST['activo']) ? 'true' : 'false';
  $id = (int) ($_POST['id'] ?? 0);

  if ($nombreCompleto === '' || $nombreUsuario === '') {
    volver('usuarios', 'error', 'Nombre y usuario son obligatorios.');
  }
  if ($contrasena !== '' && strlen($contrasena) < 12) {
    volver('usuarios', 'error', 'La contraseña debe tener al menos 12 caracteres.');
  }

  if ($accion === 'editar' && $id > 0) {
    if ($contrasena !== '') {
      $pdo->prepare(
        'UPDATE usuarios SET nombre_completo = ?, nombre_usuario = ?, contrasena_hash = ?, rol = ?, activo = ? WHERE id = ?'
      )->execute([$nombreCompleto, $nombreUsuario, password_hash($contrasena, PASSWORD_ARGON2ID), $rol, $activo, $id]);
    } else {
      $pdo->prepare(
        'UPDATE usuarios SET nombre_completo = ?, nombre_usuario = ?, rol = ?, activo = ? WHERE id = ?'
      )->execute([$nombreCompleto, $nombreUsuario, $rol, $activo, $id]);
    }
    volver('usuarios', 'ok', 'Usuario actualizado.');
  } else {
    if ($contrasena === '') {
      volver('usuarios', 'error', 'La contraseña es obligatoria para un usuario nuevo.');
    }
    $pdo->prepare(
      'INSERT INTO usuarios (nombre_completo, nombre_usuario, contrasena_hash, rol, activo) VALUES (?, ?, ?, ?, ?)'
    )->execute([$nombreCompleto, $nombreUsuario, password_hash($contrasena, PASSWORD_ARGON2ID), $rol, $activo]);
    volver('usuarios', 'ok', 'Usuario creado.');
  }
}

// módulos "normales" registrados en modulos.php
if (!array_key_exists($modulo, MODULOS)) {
  volver('convocatorias', 'error', 'Módulo no reconocido.');
}

$definicion = MODULOS[$modulo];
$tabla = $definicion['tabla'];

// titulación/campo_laboral vuelven al formulario del programa (&editar=<id>)
$esSubitemPrograma = in_array($modulo, ['titulacion', 'campo_laboral'], true);

if ($accion === 'eliminar') {
  $id = (int) ($_POST['id'] ?? 0);
  $programaIdRedirect = null;
  if ($esSubitemPrograma && $id > 0) {
    $stmtBuscar = $pdo->prepare("SELECT programa_id FROM {$tabla} WHERE id = ?");
    $stmtBuscar->execute([$id]);
    $programaIdRedirect = (int) $stmtBuscar->fetchColumn() ?: null;
  }
  if ($id > 0) {
    $pdo->prepare("DELETE FROM {$tabla} WHERE id = ?")->execute([$id]);
  }
  volverModulo($modulo, $esSubitemPrograma, $programaIdRedirect, 'ok', 'Elemento eliminado.');
}

// crear / editar
$id = (int) ($_POST['id'] ?? 0);
$programaIdRedirect = $esSubitemPrograma ? ((int) ($_POST['programa_id'] ?? 0) ?: null) : null;
$valores = [];
$erroresRequeridos = [];

foreach ($definicion['campos'] as $campo) {
  $nombre = $campo['nombre'];
  $tipo = $campo['tipo'];

  if ($tipo === 'imagen' || $tipo === 'documento') {
    try {
      $nuevoId = archivo_subir_si_viene($nombre, $usuarioId);
    } catch (RuntimeException $e) {
      volver($modulo, 'error', $e->getMessage());
    }
    if ($nuevoId !== null) {
      $valores[$nombre] = $nuevoId;
    } elseif ($accion === 'crear') {
      if (!empty($campo['requerido'])) {
        $erroresRequeridos[] = $campo['etiqueta'];
      }
      $valores[$nombre] = null;
    }
    // en edición, si no se sube archivo nuevo se deja la columna sin tocar
    continue;
  }

  $crudo = $_POST[$nombre] ?? null;

  if ($tipo === 'checkbox') {
    // PDO con emulate_prepares=false convierte bool false a '' al enlazarlo,
    // y Postgres no acepta '' como boolean -- se manda como texto 'true'/'false'.
    $valores[$nombre] = isset($_POST[$nombre]) ? 'true' : 'false';
    continue;
  }

  if ($crudo === null || trim((string) $crudo) === '') {
    if (!empty($campo['requerido'])) {
      $erroresRequeridos[] = $campo['etiqueta'];
    } elseif ($accion === 'crear' || !empty($campo['evitar_null'])) {
      // deja que la BD aplique su DEFAULT (evita violar NOT NULL)
      continue;
    } else {
      $valores[$nombre] = null;
    }
    continue;
  }

  $valores[$nombre] = match ($tipo) {
    'number', 'programa_id', 'profesor_id' => (int) $crudo,
    default => trim((string) $crudo),
  };
}

if ($erroresRequeridos !== []) {
  volverModulo($modulo, $esSubitemPrograma, $programaIdRedirect, 'error', 'Faltan campos obligatorios: ' . implode(', ', $erroresRequeridos));
}

// slug automático si se dejó vacío
if ($modulo === 'blog' && empty($valores['slug'])) {
  $valores['slug'] = generar_slug((string) ($valores['titulo'] ?? '')) . '-' . substr((string) time(), -5);
}

if ($accion === 'editar' && $id > 0) {
  if ($valores === []) {
    volverModulo($modulo, $esSubitemPrograma, $programaIdRedirect, 'ok', 'Sin cambios.');
  }
  $asignaciones = [];
  foreach ($valores as $columna => $valor) {
    $asignaciones[] = "{$columna} = :{$columna}";
  }
  $valores['id'] = $id;
  $sql = "UPDATE {$tabla} SET " . implode(', ', $asignaciones) . ' WHERE id = :id';
  $pdo->prepare($sql)->execute($valores);
} else {
  $columnas = array_keys($valores);
  $marcadores = array_map(fn($c) => ":{$c}", $columnas);
  $sql = "INSERT INTO {$tabla} (" . implode(', ', $columnas) . ') VALUES (' . implode(', ', $marcadores) . ')';
  $pdo->prepare($sql)->execute($valores);
}

volverModulo($modulo, $esSubitemPrograma, $programaIdRedirect, 'ok', 'Guardado correctamente.');

} catch (\PDOException $e) {
  error_log('[DEP-FECA] Error al guardar (' . $modulo . '/' . $accion . '): ' . $e->getMessage());

  $sqlstate = $e->getCode();
  $mensaje = match (true) {
    $sqlstate === '42P01' =>
      'Esta sección todavía no existe en la base de datos. Corre las migraciones pendientes en php/database/ e intenta de nuevo.',
    $sqlstate === '23505' =>
      'Ya existe un elemento con ese mismo valor único (código, usuario, URL amigable, etc.). Cambia ese dato e intenta de nuevo.',
    $sqlstate === '23503' && $accion === 'eliminar' =>
      'No se puede eliminar: hay otros elementos del sitio que dependen de este (por ejemplo, convocatorias de ese programa). Elimina o reasigna esos elementos primero.',
    $sqlstate === '23503' =>
      'El programa, profesor o archivo que seleccionaste ya no existe. Vuelve a seleccionarlo e intenta de nuevo.',
    $sqlstate === '23502' =>
      'Falta un dato obligatorio que el sistema requiere. Revisa el formulario completo.',
    default =>
      'No se pudo guardar. Revisa los datos e intenta de nuevo; si sigue fallando, avísale al administrador técnico.',
  };

  if (isset(MODULO_TAB_PADRE[$modulo])) {
    $esSubitemProgramaCatch = in_array($modulo, ['titulacion', 'campo_laboral'], true);
    $idContextoCatch = $esSubitemProgramaCatch ? ((int) ($_POST['programa_id'] ?? 0) ?: null) : null;
    volverModulo($modulo, $esSubitemProgramaCatch, $idContextoCatch, 'error', $mensaje);
  }
  $tabDeVuelta = array_key_exists($modulo, MODULOS) || in_array($modulo, ['imagenes', 'usuarios', 'mensajes'], true)
    ? $modulo
    : 'convocatorias';
  volver($tabDeVuelta, 'error', $mensaje);
}
