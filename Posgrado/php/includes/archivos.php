<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/app.php';

const ARCHIVOS_EXTENSIONES_PERMITIDAS = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'png', 'jpg', 'jpeg', 'gif', 'webp'];
const ARCHIVOS_TAMANO_MAXIMO = 8 * 1024 * 1024; // 8 MB

// sube $_FILES[$campo] si viene; null si no se mandó archivo
function archivo_subir_si_viene(string $campo, ?int $usuarioId): ?int {
  global $pdo;

  if (!isset($_FILES[$campo]) || $_FILES[$campo]['error'] === UPLOAD_ERR_NO_FILE) {
    return null;
  }
  if ($_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
    throw new RuntimeException('No se pudo subir el archivo.');
  }

  $originalFilename = basename($_FILES[$campo]['name']);
  $fileSize = (int) $_FILES[$campo]['size'];
  $extension = strtolower(pathinfo($originalFilename, PATHINFO_EXTENSION));

  if ($fileSize > ARCHIVOS_TAMANO_MAXIMO) {
    throw new RuntimeException('El archivo no debe pasar de 8 MB.');
  }
  if (!in_array($extension, ARCHIVOS_EXTENSIONES_PERMITIDAS, true)) {
    throw new RuntimeException('Formato no permitido. Usa PDF, Office o imágenes.');
  }

  if (!is_dir(UPLOADS_PATH)) {
    mkdir(UPLOADS_PATH, 0775, true);
  }

  $safeName = date('Ymd_His') . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
  $destination = UPLOADS_PATH . DIRECTORY_SEPARATOR . $safeName;

  if (!move_uploaded_file($_FILES[$campo]['tmp_name'], $destination)) {
    throw new RuntimeException('No se pudo guardar el archivo en uploads.');
  }

  $mimeType = mime_content_type($destination) ?: 'application/octet-stream';
  $esImagen = str_starts_with($mimeType, 'image/');
  $anchoPx = null;
  $altoPx = null;

  if ($esImagen) {
    $dimensiones = @getimagesize($destination);
    if ($dimensiones !== false) {
      [$anchoPx, $altoPx] = $dimensiones;
    }
  }

  $stmt = $pdo->prepare(
    'INSERT INTO archivos (ruta_relativa, nombre_original, tipo_mime, extension, tamano_bytes,
                            es_imagen, ancho_px, alto_px, subido_por, es_publico)
     VALUES (:ruta, :nombre, :mime, :ext, :tam, :es_imagen, :ancho, :alto, :usuario, TRUE)
     RETURNING id'
  );
  $stmt->execute([
    'ruta'     => 'uploads/' . $safeName,
    'nombre'   => $originalFilename,
    'mime'     => $mimeType,
    'ext'      => $extension,
    'tam'      => $fileSize,
    // PDO con emulate_prepares=false convierte bool false a '' al enlazarlo,
    // y Postgres no acepta '' como boolean -- se manda como texto 'true'/'false'.
    'es_imagen' => $esImagen ? 'true' : 'false',
    'ancho'    => $anchoPx,
    'alto'     => $altoPx,
    'usuario'  => $usuarioId,
  ]);

  return (int) $stmt->fetchColumn();
}
