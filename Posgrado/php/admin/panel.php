<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/content.php';
require_once __DIR__ . '/../includes/archivos.php';
require_once __DIR__ . '/modulos.php';

require_admin();

$usuario = usuario_actual();
$esControlMaestro = $usuario['rol'] === 'control_maestro';

$tabsExtra = [
  'imagenes'     => ['etiqueta' => 'Imágenes del sitio', 'icono' => 'ti-photo'],
  'estadisticas' => ['etiqueta' => 'Estadísticas',        'icono' => 'ti-chart-bar'],
];
if ($esControlMaestro) {
  $tabsExtra['usuarios'] = ['etiqueta' => 'Usuarios', 'icono' => 'ti-user-cog'];
}

$tabsValidas = array_merge(array_keys(MODULOS), array_keys($tabsExtra));
$tab = $_GET['tab'] ?? 'convocatorias';
if (!in_array($tab, $tabsValidas, true)) {
  $tab = 'convocatorias';
}
// Estos módulos no tienen tab propio: se editan dentro de otra pestaña para
// no sumar pestañas al menú (Titulación/Campo Laboral -> Oferta, Mensaje
// Institucional -> Profesores, Publicaciones -> Investigación, FAQ -> Comunidad).
const TAB_PADRE_DE = [
  'titulacion' => 'oferta', 'campo_laboral' => 'oferta',
  'mensajes' => 'profesores',
  'publicaciones' => 'investigacion',
  'faq' => 'documentos',
];
if (isset(TAB_PADRE_DE[$tab])) {
  $tab = TAB_PADRE_DE[$tab];
}
if ($tab === 'usuarios' && !$esControlMaestro) {
  $tab = 'oferta';
}

// ── Helpers de presentación ─────────────────────────────────────────

function archivo_info(?int $archivoId): ?array {
  global $pdo;
  if ($archivoId === null || $pdo === null) return null;
  $stmt = $pdo->prepare('SELECT ruta_relativa, nombre_original, es_imagen FROM archivos WHERE id = ?');
  $stmt->execute([$archivoId]);
  return $stmt->fetch() ?: null;
}

function campo_input(array $campo, array $fila, bool $esNuevo): void {
  global $pdo;
  $nombre = $campo['nombre'];
  $tipo = $campo['tipo'];
  $valor = $fila[$nombre] ?? null;
  $id = 'f-' . $nombre;
  $req = !empty($campo['requerido']);

  echo '<div class="form-group">';
  echo '<label class="form-label" for="' . h($id) . '">' . h($campo['etiqueta']) . ($req ? ' *' : '') . '</label>';

  switch ($tipo) {
    case 'textarea':
      echo '<textarea class="form-control" id="' . h($id) . '" name="' . h($nombre) . '"' . ($req ? ' required' : '') . '>' . h((string) ($valor ?? '')) . '</textarea>';
      break;

    case 'select':
      echo '<select class="form-control" id="' . h($id) . '" name="' . h($nombre) . '"' . ($req ? ' required' : '') . '>';
      echo '<option value="">Selecciona…</option>';
      foreach ($campo['opciones'] as $valOpcion => $etiquetaOpcion) {
        $sel = ((string) $valOpcion === (string) $valor) ? ' selected' : '';
        echo '<option value="' . h((string) $valOpcion) . '"' . $sel . '>' . h($etiquetaOpcion) . '</option>';
      }
      echo '</select>';
      break;

    case 'programa_id':
      $programas = $pdo !== null ? $pdo->query('SELECT id, codigo, nombre FROM programas ORDER BY nombre')->fetchAll() : [];
      echo '<select class="form-control" id="' . h($id) . '" name="' . h($nombre) . '">';
      echo '<option value="">— Ninguno —</option>';
      foreach ($programas as $p) {
        $sel = ((int) $p['id'] === (int) $valor) ? ' selected' : '';
        echo '<option value="' . (int) $p['id'] . '"' . $sel . '>' . h($p['codigo'] . ' · ' . $p['nombre']) . '</option>';
      }
      echo '</select>';
      break;

    case 'profesor_id':
      $profesores = $pdo !== null ? $pdo->query('SELECT id, nombre FROM profesores ORDER BY nombre')->fetchAll() : [];
      echo '<select class="form-control" id="' . h($id) . '" name="' . h($nombre) . '">';
      echo '<option value="">— Ninguno —</option>';
      foreach ($profesores as $p) {
        $sel = ((int) $p['id'] === (int) $valor) ? ' selected' : '';
        echo '<option value="' . (int) $p['id'] . '"' . $sel . '>' . h($p['nombre']) . '</option>';
      }
      echo '</select>';
      break;

    case 'checkbox':
      $marcado = $esNuevo ? !empty($campo['defecto']) : db_bool($valor);
      echo '<label class="inline-field"><input type="checkbox" id="' . h($id) . '" name="' . h($nombre) . '"' . ($marcado ? ' checked' : '') . '> Sí</label>';
      break;

    case 'imagen':
    case 'documento':
      $info = archivo_info($valor !== null ? (int) $valor : null);
      echo '<div class="admin-upload-zona" style="cursor:default;">';
      if ($info) {
        if (db_bool($info['es_imagen'])) {
          echo '<img class="admin-upload-preview" src="../' . h(ltrim((string) $info['ruta_relativa'], '/')) . '" alt="">';
        }
        echo '<span>Archivo actual: <a href="../' . h(ltrim((string) $info['ruta_relativa'], '/')) . '" target="_blank" rel="noopener">' . h($info['nombre_original']) . '</a></span>';
      } else {
        echo '<i class="ti ti-upload"></i><span>Sin archivo todavía</span>';
      }
      echo '<input type="file" name="' . h($nombre) . '" accept="' . ($tipo === 'imagen' ? 'image/*' : '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.png,.jpg,.jpeg,.gif,.webp') . '" style="position:static;opacity:1;height:auto;margin-top:8px;">';
      echo '</div>';
      break;

    case 'html':
      echo '<textarea class="form-control" id="' . h($id) . '" name="' . h($nombre) . '" rows="10">' . h((string) ($valor ?? '')) . '</textarea>';
      echo '<small style="color:#999;">Se permite HTML básico: párrafos, listas, negritas, enlaces, imágenes, tablas.</small>';
      break;

    default: // text, email, url, date, number
      $tipoInput = in_array($tipo, ['text', 'email', 'url', 'date', 'number'], true) ? $tipo : 'text';
      echo '<input type="' . h($tipoInput) . '" class="form-control" id="' . h($id) . '" name="' . h($nombre) . '" value="' . h((string) ($valor ?? '')) . '"' . ($req ? ' required' : '') . '>';
  }

  echo '</div>';
}

function tabla_existe(PDO $pdo, string $tabla): bool {
  try {
    return (bool) $pdo->query('SELECT to_regclass(' . $pdo->quote($tabla) . ') IS NOT NULL')->fetchColumn();
  } catch (\PDOException $e) {
    return false;
  }
}

/** Director/Jefe de Posgrado -- se editan arriba del listado de Profesores, no tienen tab propio. */
function renderizar_mensajes_institucionales_bloque(): void {
  global $pdo;
  $existe = $pdo === null || tabla_existe($pdo, 'mensajes_institucionales');
  echo '<div class="admin-card" style="padding:20px 22px;margin-bottom:26px;">';
  echo '<h3 style="margin-top:0;font-family:\'Barlow Condensed\',sans-serif;color:var(--rojo-oscuro);">Mensaje Institucional (Nosotros)</h3>';
  echo '<p style="font-size:13px;color:#888;margin-top:-6px;">Director y Jefe de Posgrado con su foto y mensaje de bienvenida. Son dos espacios fijos: no se agregan ni quitan, solo se editan.</p>';

  if (!$existe) {
    echo '<div class="panel-flash panel-flash--error"><i class="ti ti-database-off"></i> La tabla <code>mensajes_institucionales</code> todavía no existe. Corre <code>php/database/agregar_mensajes_y_faq.sql</code>.</div></div>';
    return;
  }

  $mensajes = listado_seguro(fn() => $pdo->query('SELECT m.*, a.ruta_relativa FROM mensajes_institucionales m LEFT JOIN archivos a ON a.id = m.foto_id ORDER BY m.orden_display')->fetchAll());
  $editarClave = $_GET['editar_msg'] ?? null;
  $filaMsg = null;
  foreach ($mensajes as $m) { if ($m['clave'] === $editarClave) { $filaMsg = $m; break; } }

  if ($filaMsg !== null) {
    echo '<form method="post" action="guardar.php" enctype="multipart/form-data" style="margin-bottom:20px;" onsubmit="return confirm(\'¿Guardar los cambios en este mensaje institucional?\');">';
    echo '<input type="hidden" name="modulo" value="mensajes">';
    echo '<input type="hidden" name="clave" value="' . h($filaMsg['clave']) . '">';
    echo '<div class="form-group"><label class="form-label">Nombre completo</label><input type="text" class="form-control" name="nombre" value="' . h($filaMsg['nombre']) . '" required></div>';
    echo '<div class="form-group"><label class="form-label">Cargo</label><input type="text" class="form-control" name="cargo" value="' . h($filaMsg['cargo']) . '" required></div>';
    echo '<div class="form-group"><label class="form-label">Mensaje de bienvenida</label><textarea class="form-control" name="mensaje" rows="6">' . h($filaMsg['mensaje'] ?? '') . '</textarea></div>';
    echo '<div class="form-group"><label class="form-label">Fotografía (deja vacío para conservar la actual)</label><input type="file" name="foto" accept="image/*"></div>';
    echo '<button type="submit" class="btn-sm-rojo"><i class="ti ti-device-floppy"></i> Guardar</button> ';
    echo '<a href="panel.php?tab=profesores#msg-institucional" class="btn-outline-dark">Cancelar</a>';
    echo '</form>';
  }

  echo '<div class="admin-grid" id="msg-institucional">';
  foreach ($mensajes as $m) {
    echo '<div class="admin-card">';
    if (!empty($m['ruta_relativa'])) {
      echo '<img class="admin-card-img" src="../' . h(ltrim((string) $m['ruta_relativa'], '/')) . '" alt="">';
    } else {
      echo '<div class="admin-card-img-placeholder"><i class="ti ti-user"></i></div>';
    }
    echo '<div class="admin-card-body"><div class="admin-card-title">' . h($m['nombre']) . '</div><div class="admin-card-desc">' . h($m['cargo']) . '</div></div>';
    echo '<div class="admin-card-actions"><a class="admin-btn-edit" href="panel.php?tab=profesores&editar_msg=' . h($m['clave']) . '#formulario"><i class="ti ti-pencil"></i> Editar</a></div>';
    echo '</div>';
  }
  echo '</div></div>';
}

/** Titulación y Campo Laboral de un programa -- se editan dentro del formulario del programa, no tienen tab propio. */
function renderizar_subitems_programa(int $programaId): void {
  renderizar_bloque_subitem($programaId, 'programa_titulacion', 'titulacion', 'Modalidades de Titulación', 'ti-file-text');
  renderizar_bloque_subitem($programaId, 'programa_campo_laboral', 'campo_laboral', 'Campo Laboral', 'ti-briefcase');
}

function renderizar_bloque_subitem(int $programaId, string $tabla, string $modulo, string $titulo, string $iconoDefecto): void {
  global $pdo;
  echo '<div class="admin-card" style="padding:20px 22px;margin-bottom:26px;">';
  echo '<h4 style="margin-top:0;font-family:\'Barlow Condensed\',sans-serif;color:var(--rojo-oscuro);">' . h($titulo) . '</h4>';

  $existe = $pdo === null || tabla_existe($pdo, $tabla);
  if (!$existe) {
    echo '<div class="panel-flash panel-flash--error"><i class="ti ti-database-off"></i> La tabla <code>' . h($tabla) . '</code> todavía no existe. Corre las migraciones pendientes en <code>php/database/</code>.</div></div>';
    return;
  }

  $items = listado_seguro(function () use ($pdo, $tabla, $programaId) {
    $stmt = $pdo->prepare("SELECT * FROM {$tabla} WHERE programa_id = ? ORDER BY orden_display, id");
    $stmt->execute([$programaId]);
    return $stmt->fetchAll();
  });

  $editarSub = isset($_GET['editar_' . $modulo]) ? (int) $_GET['editar_' . $modulo] : null;
  $filaSub = null;
  if ($editarSub) {
    foreach ($items as $it) { if ((int) $it['id'] === $editarSub) { $filaSub = $it; break; } }
  }

  if ($items !== []) {
    echo '<div class="admin-grid" style="margin-bottom:16px;">';
    foreach ($items as $it) {
      echo '<div class="admin-card">';
      echo '<div class="admin-card-img-placeholder" style="background:linear-gradient(135deg,#a87f3d 0%,#6d5227 100%);"><i class="ti ' . h($it['icono'] ?: $iconoDefecto) . '"></i></div>';
      echo '<div class="admin-card-body"><div class="admin-card-title">' . h($it['titulo']) . '</div>';
      if (!empty($it['descripcion'])) {
        $desc = strip_tags((string) $it['descripcion']);
        echo '<div class="admin-card-desc">' . h(mb_strlen($desc) > 90 ? mb_substr($desc, 0, 90) . '…' : $desc) . '</div>';
      }
      echo '</div>';
      echo '<div class="admin-card-actions">';
      echo '<a class="admin-btn-edit" href="panel.php?tab=oferta&editar=' . $programaId . '&editar_' . h($modulo) . '=' . (int) $it['id'] . '#sub-' . h($modulo) . '"><i class="ti ti-pencil"></i> Editar</a>';
      echo '<form method="post" action="guardar.php" onsubmit="return confirm(\'¿Eliminar este elemento?\');" style="display:inline;">';
      echo '<input type="hidden" name="modulo" value="' . h($modulo) . '"><input type="hidden" name="accion" value="eliminar"><input type="hidden" name="id" value="' . (int) $it['id'] . '">';
      echo '<button type="submit" class="admin-btn-delete" title="Eliminar"><i class="ti ti-trash"></i></button></form>';
      echo '</div></div>';
    }
    echo '</div>';
  } else {
    echo '<p style="font-size:13px;color:#999;">Sin elementos todavía para este programa.</p>';
  }

  echo '<form method="post" action="guardar.php" id="sub-' . h($modulo) . '" onsubmit="return confirm(\'' . ($filaSub ? '¿Guardar los cambios?' : '¿Agregar este elemento?') . '\');">';
  echo '<input type="hidden" name="modulo" value="' . h($modulo) . '">';
  echo '<input type="hidden" name="accion" value="' . ($filaSub ? 'editar' : 'crear') . '">';
  if ($filaSub) echo '<input type="hidden" name="id" value="' . (int) $filaSub['id'] . '">';
  echo '<input type="hidden" name="programa_id" value="' . $programaId . '">';
  echo '<div class="form-group"><label class="form-label">Título</label><input type="text" class="form-control" name="titulo" value="' . h($filaSub['titulo'] ?? '') . '" required></div>';
  echo '<div class="form-group"><label class="form-label">Ícono (clase Tabler)</label><input type="text" class="form-control" name="icono" value="' . h($filaSub['icono'] ?? '') . '" placeholder="' . h($iconoDefecto) . '"></div>';
  echo '<div class="form-group"><label class="form-label">Descripción</label><textarea class="form-control" name="descripcion">' . h($filaSub['descripcion'] ?? '') . '</textarea></div>';
  echo '<div class="form-group"><label class="form-label">Orden</label><input type="number" class="form-control" name="orden_display" value="' . h((string) ($filaSub['orden_display'] ?? 0)) . '"></div>';
  echo '<button type="submit" class="btn-sm-rojo"><i class="ti ti-device-floppy"></i> ' . ($filaSub ? 'Guardar cambios' : 'Agregar') . '</button>';
  if ($filaSub) echo ' <a href="panel.php?tab=oferta&editar=' . $programaId . '#sub-' . h($modulo) . '" class="btn-outline-dark">Cancelar edición</a>';
  echo '</form>';

  echo '</div>';
}

/** Módulo completo (con su propia tabla) incrustado dentro de otra pestaña -- ej. Publicaciones dentro de Investigación, FAQ dentro de Comunidad. Mismo patrón visual (recuadro blanco + botón Agregar) que un módulo de pestaña propia, para no mezclar dos estilos distintos. */
function renderizar_modulo_secundario(string $moduloClave, string $tabActual): void {
  global $pdo;
  if (!array_key_exists($moduloClave, MODULOS)) return;
  $definicion = MODULOS[$moduloClave];
  $tabla = $definicion['tabla'];

  echo '<div class="admin-card" style="padding:20px 22px;margin-top:32px;margin-bottom:26px;border-top:3px solid var(--rojo);" id="sub-' . h($moduloClave) . '">';

  $existe = $pdo === null || tabla_existe($pdo, $tabla);
  if (!$existe) {
    echo '<h3 style="margin-top:0;font-family:\'Barlow Condensed\',sans-serif;color:var(--rojo-oscuro);">' . h($definicion['etiqueta']) . '</h3>';
    echo '<div class="panel-flash panel-flash--error"><i class="ti ti-database-off"></i> La tabla <code>' . h($tabla) . '</code> todavía no existe. Corre las migraciones pendientes en <code>php/database/</code>.</div></div>';
    return;
  }

  $filas = listado_seguro(fn() => $pdo->query("SELECT * FROM {$tabla} ORDER BY {$definicion['orden']}")->fetchAll());
  $paramEditar = 'editar_' . $moduloClave;
  $paramNuevo = 'nuevo_' . $moduloClave;
  $editarId = isset($_GET[$paramEditar]) ? (int) $_GET[$paramEditar] : null;
  $esNuevo = isset($_GET[$paramNuevo]);
  $filaForm = [];
  if ($editarId) {
    foreach ($filas as $f) { if ((int) $f['id'] === $editarId) { $filaForm = $f; break; } }
  }

  echo '<div class="admin-panel-hdr">';
  echo '<div class="admin-panel-hdr-left"><h3 style="margin:0;">' . h($definicion['etiqueta']) . '</h3><span class="admin-count-badge">' . count($filas) . ' elemento' . (count($filas) !== 1 ? 's' : '') . '</span></div>';
  echo '<a href="panel.php?tab=' . h($tabActual) . '&' . $paramNuevo . '=1#sub-' . h($moduloClave) . '" class="btn-sm-rojo"><i class="ti ti-plus"></i> Agregar ' . h($definicion['etiqueta_item']) . '</a>';
  echo '</div>';

  if ($editarId || $esNuevo) {
    $esNuevoReal = !$editarId;
    $mensajeConfirmar = $esNuevoReal
      ? '¿Agregar ' . h($definicion['etiqueta_item']) . '?'
      : '¿Guardar los cambios en ' . h($definicion['etiqueta_item']) . '?';
    echo '<form method="post" action="guardar.php" enctype="multipart/form-data" style="margin-top:16px;" onsubmit="return confirm(\'' . $mensajeConfirmar . '\');">';
    echo '<input type="hidden" name="modulo" value="' . h($moduloClave) . '">';
    echo '<input type="hidden" name="accion" value="' . ($esNuevoReal ? 'crear' : 'editar') . '">';
    if (!$esNuevoReal) echo '<input type="hidden" name="id" value="' . (int) $filaForm['id'] . '">';
    foreach ($definicion['campos'] as $campo) {
      campo_input($campo, $filaForm, $esNuevoReal);
    }
    echo '<button type="submit" class="btn-sm-rojo"><i class="ti ti-device-floppy"></i> ' . ($esNuevoReal ? 'Agregar' : 'Guardar cambios') . '</button> ';
    echo '<a href="panel.php?tab=' . h($tabActual) . '#sub-' . h($moduloClave) . '" class="btn-outline-dark">Cancelar</a>';
    echo '</form>';
  }

  echo '<div class="admin-grid" style="margin-top:20px;">';
  foreach ($filas as $fila) {
    $acento = ACENTOS_MODULO[$moduloClave] ?? ['#951823', '#3a3a3a'];
    $urlEditar = 'panel.php?tab=' . h($tabActual) . '&' . $paramEditar . '=' . (int) $fila['id'] . '#sub-' . h($moduloClave);
    echo '<div class="admin-card" style="cursor:pointer;" onclick="if(!event.target.closest(\'.admin-card-actions\')) window.location.href=\'' . $urlEditar . '\';">';
    echo '<div class="admin-card-img-placeholder" style="background:linear-gradient(135deg,' . h($acento[0]) . ' 0%,' . h($acento[1]) . ' 100%);"><i class="ti ' . h($definicion['icono']) . '"></i></div>';
    echo '<div class="admin-card-body"><div class="admin-card-title">' . h((string) ($fila[$definicion['titulo_campo']] ?? '')) . '</div></div>';
    echo '<div class="admin-card-actions">';
    echo '<a class="admin-btn-edit" href="' . $urlEditar . '"><i class="ti ti-pencil"></i> Editar</a>';
    echo '<form method="post" action="guardar.php" onsubmit="return confirm(\'¿Eliminar este elemento?\');" style="display:inline;">';
    echo '<input type="hidden" name="modulo" value="' . h($moduloClave) . '"><input type="hidden" name="accion" value="eliminar"><input type="hidden" name="id" value="' . (int) $fila['id'] . '">';
    echo '<button type="submit" class="admin-btn-delete" title="Eliminar"><i class="ti ti-trash"></i></button></form>';
    echo '</div></div>';
  }
  if ($filas === []) echo '<div class="admin-empty"><i class="ti ti-inbox"></i><p>Sin elementos todavía.</p></div>';
  echo '</div>';

  echo '</div>';
}

function renderizar_formulario(string $modulo, array $definicion, array $fila, bool $esNuevo): void {
  echo '<div class="admin-card" style="padding:20px 22px;margin-bottom:26px;" id="formulario">';
  echo '<h3 style="margin-top:0;font-family:\'Barlow Condensed\',sans-serif;color:var(--rojo-oscuro);">';
  echo ($esNuevo ? 'Agregar ' : 'Editar ') . h($definicion['etiqueta_item']);
  echo '</h3>';
  $mensajeConfirmar = $esNuevo
    ? '¿Agregar ' . h($definicion['etiqueta_item']) . '?'
    : '¿Guardar los cambios en ' . h($definicion['etiqueta_item']) . '?';
  echo '<form method="post" action="guardar.php" enctype="multipart/form-data" onsubmit="return confirm(\'' . $mensajeConfirmar . '\');">';
  echo '<input type="hidden" name="modulo" value="' . h($modulo) . '">';
  echo '<input type="hidden" name="accion" value="' . ($esNuevo ? 'crear' : 'editar') . '">';
  if (!$esNuevo) {
    echo '<input type="hidden" name="id" value="' . (int) $fila['id'] . '">';
  }
  foreach ($definicion['campos'] as $campo) {
    campo_input($campo, $fila, $esNuevo);
  }
  echo '<button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i> Guardar</button> ';
  echo '<a href="panel.php?tab=' . h($modulo) . '" class="btn-outline-dark">Cancelar</a>';
  echo '</form></div>';
}

/** Degradado de acento por módulo, mismos 3 tonos que ya usa el hero de Inicio. */
const ACENTOS_MODULO = [
  'oferta'        => ['#a87f3d', '#6d5227'],
  'titulacion'    => ['#a87f3d', '#6d5227'],
  'campo_laboral' => ['#a87f3d', '#6d5227'],
  'convocatorias' => ['#b71c1c', '#7f0000'],
  'profesores'    => ['#1a3a5c', '#0d2035'],
  'investigacion' => ['#1a3a5c', '#0d2035'],
  'blog'          => ['#a87f3d', '#6d5227'],
  'publicaciones' => ['#1a3a5c', '#0d2035'],
  'documentos'    => ['#a87f3d', '#6d5227'],
  'faq'           => ['#1a3a5c', '#0d2035'],
];

function renderizar_grid(string $modulo, array $definicion, array $filas): void {
  echo '<div class="admin-panel-hdr">';
  echo '<div class="admin-panel-hdr-left"><h3>' . h($definicion['etiqueta']) . '</h3><span class="admin-count-badge">' . count($filas) . ' elemento' . (count($filas) !== 1 ? 's' : '') . '</span></div>';
  echo '<a href="panel.php?tab=' . h($modulo) . '&nuevo=1#formulario" class="btn-sm-rojo"><i class="ti ti-plus"></i> Agregar ' . h($definicion['etiqueta_item']) . '</a>';
  echo '</div>';

  if ($filas === []) {
    echo '<div class="admin-empty"><i class="ti ti-inbox"></i><p>Sin elementos todavía.</p></div>';
    return;
  }

  $campoImagen = null;
  $campoDesc = null;
  $camposTag = [];
  $iconosPorTipo = ['date' => 'ti-calendar', 'select' => 'ti-tag', 'number' => 'ti-hash'];
  foreach ($definicion['campos'] as $c) {
    if ($campoImagen === null && in_array($c['tipo'], ['imagen', 'documento'], true)) $campoImagen = $c['nombre'];
    if ($campoDesc === null && in_array($c['tipo'], ['textarea', 'html'], true)) $campoDesc = $c['nombre'];
    // Campos cortos y legibles con solo SELECT * (sin joins) -- fechas, selects
    // y números. Se excluyen programa_id/profesor_id: sin el join solo se
    // vería el id numérico, no el nombre, y eso no le sirve a nadie.
    if (in_array($c['tipo'], ['date', 'select', 'number'], true) && $c['nombre'] !== $definicion['titulo_campo']) {
      $camposTag[] = ['nombre' => $c['nombre'], 'icono' => $iconosPorTipo[$c['tipo']]];
    }
  }
  $camposTag = array_slice($camposTag, 0, 3);

  echo '<div class="admin-grid">';
  foreach ($filas as $fila) {
    $urlEditar = 'panel.php?tab=' . h($modulo) . '&editar=' . (int) $fila['id'] . '#formulario';
    echo '<div class="admin-card" style="cursor:pointer;" onclick="if(!event.target.closest(\'.admin-card-actions\')) window.location.href=\'' . $urlEditar . '\';">';

    $info = $campoImagen ? archivo_info(isset($fila[$campoImagen]) ? (int) $fila[$campoImagen] : null) : null;
    if ($info && db_bool($info['es_imagen'])) {
      echo '<img class="admin-card-img" src="../' . h(ltrim((string) $info['ruta_relativa'], '/')) . '" alt="">';
    } else {
      $acento = ACENTOS_MODULO[$modulo] ?? ['#951823', '#3a3a3a'];
      echo '<div class="admin-card-img-placeholder" style="background:linear-gradient(135deg,' . h($acento[0]) . ' 0%,' . h($acento[1]) . ' 100%);"><i class="ti ' . h($definicion['icono']) . '"></i></div>';
    }

    echo '<div class="admin-card-body">';
    if ($modulo === 'convocatorias' && array_key_exists('fecha_cierre', $fila)) {
      $vigente = empty($fila['fecha_cierre']) || $fila['fecha_cierre'] >= date('Y-m-d');
      echo '<span class="admin-badge ' . ($vigente ? 'admin-badge-vigente' : 'admin-badge-cerrada') . '">' . ($vigente ? 'Vigente' : 'Cerrada') . '</span>';
    }
    echo '<div class="admin-card-title">' . h((string) ($fila[$definicion['titulo_campo']] ?? '')) . '</div>';
    if ($campoDesc && !empty($fila[$campoDesc])) {
      $desc = strip_tags((string) $fila[$campoDesc]);
      echo '<div class="admin-card-desc">' . h(mb_strlen($desc) > 110 ? mb_substr($desc, 0, 110) . '…' : $desc) . '</div>';
    }
    $tagsConValor = array_filter($camposTag, fn($t) => !empty($fila[$t['nombre']]));
    if ($tagsConValor !== []) {
      echo '<div class="admin-card-tags">';
      foreach ($tagsConValor as $t) {
        echo '<span class="admin-card-tag"><i class="ti ' . h($t['icono']) . '"></i> ' . h((string) $fila[$t['nombre']]) . '</span>';
      }
      echo '</div>';
    }
    foreach (['es_publicado', 'activo'] as $campoEstado) {
      if (array_key_exists($campoEstado, $fila)) {
        $publicado = db_bool($fila[$campoEstado]);
        echo '<span class="admin-badge ' . ($publicado ? 'admin-badge-vigente' : 'admin-badge-borrador') . '">' . ($publicado ? 'Publicado' : 'Borrador') . '</span>';
      }
    }
    echo '</div>';

    echo '<div class="admin-card-actions">';
    echo '<a class="admin-btn-edit" href="' . $urlEditar . '"><i class="ti ti-pencil"></i> Editar</a>';
    echo '<form method="post" action="guardar.php" onsubmit="return confirm(\'¿Eliminar este elemento?\');" style="display:inline;">';
    echo '<input type="hidden" name="modulo" value="' . h($modulo) . '">';
    echo '<input type="hidden" name="accion" value="eliminar">';
    echo '<input type="hidden" name="id" value="' . (int) $fila['id'] . '">';
    echo '<button type="submit" class="admin-btn-delete" title="Eliminar"><i class="ti ti-trash"></i></button>';
    echo '</form>';
    echo '</div>';

    echo '</div>';
  }
  echo '</div>';
}

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración · Posgrado FECA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700&family=Barlow+Condensed:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>

  <header class="panel-header">
    <div class="panel-header-title">
      Panel de Administración
      <small>División de Estudios de Posgrado · FECA UJED</small>
    </div>
    <nav class="panel-header-nav">
      <div class="panel-header-user">
        <span class="panel-header-avatar"><?= h(mb_strtoupper(mb_substr($usuario['nombre'], 0, 1))) ?></span>
        <div class="panel-header-user-info">
          <span class="panel-header-user-nombre"><?= h($usuario['nombre']) ?></span>
          <span class="panel-header-rol panel-header-rol--<?= h($usuario['rol']) ?>">
            <?= $esControlMaestro ? 'Control Maestro' : 'Administrador' ?>
          </span>
        </div>
      </div>
      <span class="panel-header-divisor"></span>
      <a class="panel-header-btn panel-header-btn--salir" href="logout.php"><i class="ti ti-logout"></i> Salir</a>
    </nav>
  </header>

  <main class="panel-main">

    <?php if ($pdo === null): ?>
      <div class="panel-flash panel-flash--error">
        <i class="ti ti-database-off"></i> No hay conexión a PostgreSQL configurada (revisa las variables PGHOST/PGDATABASE/PGUSER/PGPASSWORD). El panel no puede leer ni guardar datos hasta que se conecte.
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['ok'])): ?>
      <div class="panel-flash panel-flash--ok" id="panel-flash-msg" tabindex="-1"><i class="ti ti-check"></i> <?= h($_GET['msg'] ?? 'Hecho.') ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
      <div class="panel-flash panel-flash--error" id="panel-flash-msg" tabindex="-1"><i class="ti ti-alert-circle"></i> <?= h($_GET['msg'] ?? 'Ocurrió un error.') ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['ok']) || isset($_GET['error'])): ?>
      <script>
        (function () {
          var msg = document.getElementById('panel-flash-msg');
          if (!msg) return;
          msg.scrollIntoView({ behavior: 'smooth', block: 'center' });
          msg.focus({ preventScroll: true });
          msg.style.animation = 'panelFlashPulso 1.1s ease-in-out 2';
        })();
      </script>
      <style>
        @keyframes panelFlashPulso {
          0%, 100% { box-shadow: none; }
          50% { box-shadow: 0 0 0 4px rgba(227,19,19,0.25); }
        }
      </style>
    <?php endif; ?>

    <div class="admin-tabs">
      <?php foreach (MODULOS as $clave => $def): ?>
        <?php if (!empty($def['oculto_en_nav'])) continue; ?>
        <a class="admin-tab-btn <?= $tab === $clave ? 'activo' : '' ?>" href="panel.php?tab=<?= h($clave) ?>">
          <i class="ti <?= h($def['icono']) ?>"></i> <?= h($def['etiqueta']) ?>
        </a>
      <?php endforeach; ?>
      <?php foreach ($tabsExtra as $clave => $def): ?>
        <a class="admin-tab-btn <?= $tab === $clave ? 'activo' : '' ?>" href="panel.php?tab=<?= h($clave) ?>">
          <i class="ti <?= h($def['icono']) ?>"></i> <?= h($def['etiqueta']) ?>
        </a>
      <?php endforeach; ?>
    </div>

    <?php if (array_key_exists($tab, MODULOS)):
      $definicion = MODULOS[$tab];
      $tablaExiste = $pdo === null || tabla_existe($pdo, $definicion['tabla']);
      $filas = $tablaExiste ? listado_seguro(fn() => $pdo->query("SELECT * FROM {$definicion['tabla']} ORDER BY {$definicion['orden']}")->fetchAll()) : [];
      if (!$tablaExiste): ?>
        <div class="panel-flash panel-flash--error">
          <i class="ti ti-database-off"></i> La tabla <code><?= h($definicion['tabla']) ?></code> todavía no existe en la base de datos. Corre las migraciones pendientes en <code>php/database/</code> antes de usar esta sección.
        </div>
      <?php endif;

      if ($tab === 'profesores') renderizar_mensajes_institucionales_bloque();

      $editarId = isset($_GET['editar']) ? (int) $_GET['editar'] : null;
      $esNuevo = isset($_GET['nuevo']);
      $editarNoEncontrado = false;
      if ($editarId || $esNuevo) {
        $filaForm = [];
        if ($editarId) {
          foreach ($filas as $f) { if ((int) $f['id'] === $editarId) { $filaForm = $f; break; } }
          $editarNoEncontrado = $filaForm === [];
        }
        if (!$editarNoEncontrado) {
          renderizar_formulario($tab, $definicion, $filaForm, !$editarId);
          if ($tab === 'oferta' && $editarId) {
            renderizar_subitems_programa($editarId);
          }
        }
      }
      if ($editarNoEncontrado): ?>
        <div class="panel-flash panel-flash--error">
          <i class="ti ti-alert-circle"></i> Ese elemento ya no existe (puede que alguien más lo haya eliminado). Elige uno de la lista de abajo.
        </div>
      <?php endif;
      $moduloSecundarioPorTab = ['investigacion' => 'publicaciones', 'documentos' => 'faq'];
      renderizar_grid($tab, $definicion, $filas);
      isset($moduloSecundarioPorTab[$tab]) && renderizar_modulo_secundario($moduloSecundarioPorTab[$tab], $tab);
    elseif ($tab === 'imagenes'):
      $imagenes = $pdo !== null ? $pdo->query('SELECT i.*, a.ruta_relativa FROM imagenes_sitio i LEFT JOIN archivos a ON a.id = i.imagen_id ORDER BY i.clave')->fetchAll() : [];
      ?>
      <div class="admin-panel-hdr">
        <div class="admin-panel-hdr-left"><h3>Imágenes del sitio</h3></div>
      </div>
      <p style="font-size:13px;color:#888;margin-top:-10px;">
        Galería de Inicio y Organigrama de Nosotros. Sube un archivo nuevo para reemplazar la imagen actual de cada espacio.
      </p>
      <div class="admin-grid">
        <?php foreach ($imagenes as $img): ?>
          <div class="admin-card">
            <?php if (!empty($img['ruta_relativa'])): ?>
              <img class="admin-card-img" src="../<?= h(ltrim((string) $img['ruta_relativa'], '/')) ?>" alt="">
            <?php else: ?>
              <div class="admin-card-img-placeholder"><i class="ti ti-photo"></i></div>
            <?php endif; ?>
            <div class="admin-card-body">
              <div class="admin-card-title"><?= h($img['etiqueta']) ?></div>
              <form method="post" action="guardar.php" enctype="multipart/form-data" style="margin-top:10px;">
                <input type="hidden" name="modulo" value="imagenes">
                <input type="hidden" name="clave" value="<?= h($img['clave']) ?>">
                <input type="file" name="imagen" accept="image/*" required style="width:100%;">
                <button type="submit" class="btn-sm-rojo" style="margin-top:8px;"><i class="ti ti-upload"></i> Reemplazar</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    <?php elseif ($tab === 'estadisticas'): ?>
      <style>
        .stats-kpis { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:14px; margin-bottom:28px; }
        .stats-kpi { background:#fff; border:1px solid rgba(0,0,0,0.07); border-radius:8px; padding:18px 20px; }
        .stats-kpi--top { border-left:3px solid var(--dorado); }
        .stats-kpi-num { font-size:34px; font-weight:800; color:var(--rojo); line-height:1; }
        .stats-kpi-lbl { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#aaa; margin-top:5px; }
        .stats-kpi-sub { font-size:12px; font-weight:600; color:var(--dorado); margin-top:2px; }
        .stats-chart-wrap { background:#fff; border:1px solid rgba(0,0,0,0.07); border-radius:8px; padding:24px 28px; }
        .stats-chart-ttl { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.09em; color:#aaa; margin-bottom:18px; display:flex; align-items:center; gap:8px; }
        .stats-bar-row { display:grid; grid-template-columns:160px 1fr 44px; align-items:center; gap:12px; padding:5px 0; }
        .stats-bar-lbl { font-size:13px; font-weight:600; color:#444; text-align:right; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .stats-bar-track { height:24px; background:#f4f4f4; border-radius:4px; overflow:hidden; position:relative; }
        .stats-bar-fill { height:100%; border-radius:4px; background:linear-gradient(90deg,var(--rojo-oscuro),var(--rojo)); transition:width .7s cubic-bezier(.4,0,.2,1); min-width:4px; }
        .stats-bar-fill--top { background:linear-gradient(90deg,var(--dorado),#c8993e); }
        .stats-bar-num { font-size:13px; font-weight:800; color:#555; text-align:right; }
        .stats-empty { text-align:center; padding:48px 20px; color:#ccc; }
        .stats-empty i { font-size:52px; display:block; margin-bottom:12px; color:#ddd; }
        .stats-empty p { font-size:13px; color:#bbb; }
      </style>

      <div class="admin-panel-hdr">
        <div style="display:flex;align-items:center;gap:12px;">
          <h3>Estadísticas de Uso</h3>
          <span style="font-size:11px;font-weight:600;color:#aaa;padding:3px 8px;background:#f5f5f5;border-radius:99px;">Este dispositivo</span>
        </div>
        <button class="btn-sm-outline" onclick="statsReset()" style="color:#e31313;border-color:#e31313;">
          <i class="ti ti-trash"></i> Borrar datos
        </button>
      </div>

      <div class="stats-kpis" id="stats-kpis"></div>

      <div class="stats-chart-wrap">
        <div class="stats-chart-ttl">
          <i class="ti ti-chart-bar" style="font-size:14px;"></i>
          Visitas por sección · ordenadas de mayor a menor
        </div>
        <div id="stats-bars"></div>
      </div>

      <p style="font-size:11px;color:#bbb;margin-top:12px;font-style:italic;display:flex;align-items:center;gap:5px;">
        <i class="ti ti-info-circle" style="font-size:13px;color:var(--dorado);"></i>
        Los datos se almacenan en este navegador (localStorage), tomados de las visitas reales al sitio público. Solo reflejan este dispositivo.
      </p>

      <script>
      (function () {
        var STATS_KEY = 'dep_stats_v1';
        var STATS_LABELS = {
          inicio: 'Inicio', nosotros: 'Nosotros', oferta_educativa: 'Oferta Educativa',
          investigacion: 'Investigación', comunidad: 'Comunidad', blog: 'Blog / Noticias',
          contacto: 'Contacto', convocatorias: 'Convocatorias', publicaciones: 'Publicaciones',
          transparencia: 'Transparencia', titulacion: 'Titulación',
          grupos_disciplinares: 'Grupos Disciplinares',
        };

        function etiquetaStat(clave) {
          return STATS_LABELS[clave] || clave;
        }

        function render() {
          var raw = {};
          try { raw = JSON.parse(localStorage.getItem(STATS_KEY) || '{}'); } catch (_) {}

          // Cada programa visitado (#program_dgo, #program_me...) se suma dentro
          // de "Oferta Educativa" en vez de aparecer como una fila propia.
          var agrupado = {};
          Object.keys(raw).forEach(function (clave) {
            var claveFinal = clave.indexOf('program_') === 0 ? 'oferta_educativa' : clave;
            agrupado[claveFinal] = (agrupado[claveFinal] || 0) + raw[clave];
          });

          var entradas = Object.entries(agrupado).sort(function (a, b) { return b[1] - a[1]; });
          var total = entradas.reduce(function (s, e) { return s + e[1]; }, 0);
          var maximo = entradas.length ? entradas[0][1] : 1;
          var top = entradas.length ? entradas[0] : null;

          var kpisEl = document.getElementById('stats-kpis');
          kpisEl.innerHTML =
            '<div class="stats-kpi"><div class="stats-kpi-num">' + total + '</div><div class="stats-kpi-lbl">Visitas totales</div></div>' +
            '<div class="stats-kpi"><div class="stats-kpi-num">' + entradas.length + '</div><div class="stats-kpi-lbl">Secciones visitadas</div></div>' +
            (top
              ? '<div class="stats-kpi stats-kpi--top"><div class="stats-kpi-num" style="font-size:20px;line-height:1.2;">' + etiquetaStat(top[0]) + '</div><div class="stats-kpi-lbl">Más visitada</div><div class="stats-kpi-sub">' + top[1] + ' visita' + (top[1] !== 1 ? 's' : '') + '</div></div>'
              : '');

          var barsEl = document.getElementById('stats-bars');
          if (entradas.length === 0) {
            barsEl.innerHTML = '<div class="stats-empty"><i class="ti ti-chart-bar-off"></i><p>Sin datos todavía.<br>Navega por las secciones del sitio público para que aparezcan aquí.</p></div>';
            return;
          }
          barsEl.innerHTML = entradas.map(function (e, i) {
            var pct = Math.max(4, Math.round((e[1] / maximo) * 100));
            return '<div class="stats-bar-row">' +
              '<div class="stats-bar-lbl">' + etiquetaStat(e[0]) + '</div>' +
              '<div class="stats-bar-track"><div class="stats-bar-fill' + (i === 0 ? ' stats-bar-fill--top' : '') + '" style="width:' + pct + '%;"></div></div>' +
              '<div class="stats-bar-num">' + e[1] + '</div>' +
            '</div>';
          }).join('');
        }

        window.statsReset = function () {
          if (!confirm('¿Borrar las estadísticas de visitas de este navegador? No se puede deshacer.')) return;
          localStorage.removeItem(STATS_KEY);
          render();
        };

        render();
      })();
      </script>

    <?php elseif ($tab === 'usuarios' && $esControlMaestro):
      $usuarios = $pdo !== null ? $pdo->query('SELECT id, nombre_completo, nombre_usuario, rol, activo, creado_en FROM usuarios ORDER BY nombre_completo')->fetchAll() : [];
      $editarId = isset($_GET['editar']) ? (int) $_GET['editar'] : null;
      $esNuevo = isset($_GET['nuevo']);
      $filaForm = ['nombre_completo' => '', 'nombre_usuario' => '', 'rol' => 'administrador', 'activo' => true];
      $editarNoEncontrado = false;
      if ($editarId) {
        foreach ($usuarios as $u) { if ((int) $u['id'] === $editarId) { $filaForm = $u; break; } }
        $editarNoEncontrado = !isset($filaForm['id']);
      }
      ?>
      <?php if ($editarNoEncontrado): ?>
        <div class="panel-flash panel-flash--error">
          <i class="ti ti-alert-circle"></i> Ese usuario ya no existe (puede que alguien más lo haya eliminado). Elige uno de la lista de abajo.
        </div>
      <?php elseif ($editarId || $esNuevo): ?>
        <div class="admin-card" style="padding:20px 22px;margin-bottom:26px;" id="formulario">
          <h3 style="margin-top:0;font-family:'Barlow Condensed',sans-serif;color:var(--rojo-oscuro);"><?= $editarId ? 'Editar' : 'Agregar' ?> usuario</h3>
          <form method="post" action="guardar.php">
            <input type="hidden" name="modulo" value="usuarios">
            <input type="hidden" name="accion" value="<?= $editarId ? 'editar' : 'crear' ?>">
            <?php if ($editarId): ?><input type="hidden" name="id" value="<?= (int) $filaForm['id'] ?>"><?php endif; ?>
            <div class="form-group">
              <label class="form-label">Nombre completo *</label>
              <input class="form-control" name="nombre_completo" value="<?= h((string) $filaForm['nombre_completo']) ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label">Usuario (para iniciar sesión) *</label>
              <input class="form-control" name="nombre_usuario" value="<?= h((string) $filaForm['nombre_usuario']) ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label">Contraseña <?= $editarId ? '(déjalo vacío para no cambiarla)' : '*' ?></label>
              <input type="password" class="form-control" name="contrasena" <?= $editarId ? '' : 'required' ?>>
            </div>
            <div class="form-group">
              <label class="form-label">Rol *</label>
              <select class="form-control" name="rol" required>
                <option value="administrador" <?= ($filaForm['rol'] ?? '') === 'administrador' ? 'selected' : '' ?>>Administrador (acceso a todo, sin gestionar usuarios)</option>
                <option value="control_maestro" <?= ($filaForm['rol'] ?? '') === 'control_maestro' ? 'selected' : '' ?>>Control Maestro (acceso a todo + Usuarios)</option>
              </select>
            </div>
            <div class="form-group">
              <label class="inline-field"><input type="checkbox" name="activo" <?= db_bool($filaForm['activo'] ?? true) ? 'checked' : '' ?>> Cuenta activa</label>
            </div>
            <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i> Guardar</button>
            <a href="panel.php?tab=usuarios" class="btn-outline-dark">Cancelar</a>
          </form>
        </div>
      <?php endif; ?>

      <div class="admin-panel-hdr">
        <div class="admin-panel-hdr-left"><h3>Usuarios</h3><span class="admin-count-badge"><?= count($usuarios) ?></span></div>
        <a href="panel.php?tab=usuarios&nuevo=1#formulario" class="btn-sm-rojo"><i class="ti ti-plus"></i> Agregar usuario</a>
      </div>
      <table class="admin-table">
        <thead><tr><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Estado</th><th></th></tr></thead>
        <tbody>
          <?php foreach ($usuarios as $u): ?>
            <tr>
              <td><?= h($u['nombre_completo']) ?></td>
              <td><?= h($u['nombre_usuario']) ?></td>
              <td><?= $u['rol'] === 'control_maestro' ? 'Control Maestro' : 'Administrador' ?></td>
              <td><span class="admin-badge <?= db_bool($u['activo']) ? 'admin-badge-vigente' : 'admin-badge-borrador' ?>"><?= db_bool($u['activo']) ? 'Activa' : 'Inactiva' ?></span></td>
              <td>
                <a class="admin-btn-edit" href="panel.php?tab=usuarios&editar=<?= (int) $u['id'] ?>#formulario"><i class="ti ti-pencil"></i> Editar</a>
                <?php if ((int) $u['id'] !== (int) $usuario['id']): ?>
                  <form method="post" action="guardar.php" onsubmit="return confirm('¿Eliminar este usuario?');" style="display:inline;">
                    <input type="hidden" name="modulo" value="usuarios">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                    <button type="submit" class="admin-btn-delete" title="Eliminar"><i class="ti ti-trash"></i></button>
                  </form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if ($usuarios === []): ?><tr><td colspan="5">Todavía no hay usuarios.</td></tr><?php endif; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </main>
</body>
</html>
