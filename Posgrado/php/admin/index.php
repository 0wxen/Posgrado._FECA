<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/content.php';
require_admin();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? 'create';

  if ($action === 'delete') {
    $id = (int) ($_POST['id'] ?? 0);

    if ($id > 0) {
      $statement = $pdo->prepare('SELECT file_path FROM content_items WHERE id = ?');
      $statement->execute([$id]);
      $item = $statement->fetch();

      $delete = $pdo->prepare('DELETE FROM content_items WHERE id = ?');
      $delete->execute([$id]);

      if (!empty($item['file_path'])) {
        $absolutePath = APP_ROOT . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $item['file_path']);
        $realUploadPath = realpath(UPLOADS_PATH);
        $realFilePath = realpath($absolutePath);

        if ($realUploadPath && $realFilePath && is_file($realFilePath) && str_starts_with($realFilePath, $realUploadPath)) {
          unlink($realFilePath);
        }
      }

      $message = 'Contenido eliminado correctamente.';
    }
  } else {
    $contentType = $_POST['content_type'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $isPublished = isset($_POST['is_published']);
    $filePath = null;
    $originalFilename = null;
    $mimeType = null;
    $fileSize = null;

    if (!array_key_exists($contentType, CONTENT_TYPES)) {
      $error = 'Selecciona un tipo de contenido valido.';
    } elseif ($title === '') {
      $error = 'Escribe un titulo.';
    }

    if ($error === '' && isset($_FILES['upload']) && $_FILES['upload']['error'] !== UPLOAD_ERR_NO_FILE) {
      if ($_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
        $error = 'No se pudo subir el archivo.';
      } else {
        $maxSize = 8 * 1024 * 1024;
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'png', 'jpg', 'jpeg', 'gif', 'webp'];
        $originalFilename = basename($_FILES['upload']['name']);
        $fileSize = (int) $_FILES['upload']['size'];
        $extension = strtolower(pathinfo($originalFilename, PATHINFO_EXTENSION));

        if ($fileSize > $maxSize) {
          $error = 'El archivo no debe pasar de 8 MB.';
        } elseif (!in_array($extension, $allowedExtensions, true)) {
          $error = 'Formato no permitido. Usa PDF, Office o imagenes.';
        } else {
          if (!is_dir(UPLOADS_PATH)) {
            mkdir(UPLOADS_PATH, 0775, true);
          }

          $safeName = date('Ymd_His') . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
          $destination = UPLOADS_PATH . DIRECTORY_SEPARATOR . $safeName;

          if (!move_uploaded_file($_FILES['upload']['tmp_name'], $destination)) {
            $error = 'No se pudo guardar el archivo en uploads.';
          } else {
            $filePath = 'uploads/' . $safeName;
            $mimeType = mime_content_type($destination) ?: null;
          }
        }
      }
    }

    if ($error === '') {
      $insert = $pdo->prepare(
        'INSERT INTO content_items (content_type, title, description, file_path, original_filename, mime_type, file_size, is_published)
         VALUES (:content_type, :title, :description, :file_path, :original_filename, :mime_type, :file_size, :is_published)'
      );

      $insert->execute([
        'content_type' => $contentType,
        'title' => $title,
        'description' => $description !== '' ? $description : null,
        'file_path' => $filePath,
        'original_filename' => $originalFilename,
        'mime_type' => $mimeType,
        'file_size' => $fileSize,
        'is_published' => $isPublished,
      ]);

      $message = 'Contenido guardado correctamente.';
    }
  }
}

$items = $pdo
  ->query('SELECT id, content_type, title, file_path, original_filename, is_published, created_at FROM content_items ORDER BY created_at DESC, id DESC')
  ->fetchAll();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de cargas - Posgrado FECA</title>
    <style>
      body {
        margin: 0;
        background: #f8f7f5;
        color: #3a3a3a;
        font-family: Arial, sans-serif;
      }

      header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 32px;
        background: #1a1a1a;
        color: #fff;
      }

      header a {
        color: #fff;
      }

      main {
        width: min(1080px, calc(100% - 32px));
        margin: 32px auto;
        display: grid;
        gap: 24px;
      }

      section {
        background: #fff;
        border-top: 4px solid #e31313;
        padding: 24px;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
      }

      h1,
      h2,
      p {
        margin-top: 0;
      }

      form {
        display: grid;
        gap: 16px;
      }

      label {
        display: grid;
        gap: 6px;
        font-weight: 700;
      }

      input,
      select,
      textarea,
      button {
        font: inherit;
      }

      input,
      select,
      textarea {
        border: 1px solid #b9c7c7;
        padding: 10px;
      }

      textarea {
        min-height: 150px;
        resize: vertical;
      }

      button {
        width: fit-content;
        border: 0;
        background: #e31313;
        color: #fff;
        padding: 11px 18px;
        cursor: pointer;
        font-weight: 700;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      th,
      td {
        border-bottom: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        vertical-align: top;
      }

      th {
        color: #951823;
      }

      .notice {
        color: #951823;
        font-weight: 700;
      }

      .success {
        color: #1f7a3a;
        font-weight: 700;
      }

      .inline-field {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
      }

      .inline-field input {
        width: 18px;
        min-height: 18px;
      }

      .delete-button {
        background: #3a3a3a;
        padding: 8px 12px;
      }
    </style>
  </head>
  <body>
    <header>
      <strong>Panel de cargas</strong>
      <nav>
        <a href="../principal.php?page=inicio">Ver sitio</a>
        <span aria-hidden="true"> - </span>
        <a href="logout.php">Salir</a>
      </nav>
    </header>

    <main>
      <section>
        <h1>Contenido para publicar</h1>
        <p>
          Este apartado queda separado del sitio principal y protegido por credenciales.
          Aqui puedes guardar noticias, convocatorias, documentos o imagenes en PostgreSQL.
        </p>
        <?php if ($message): ?>
          <p class="success"><?= h($message) ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
          <p class="notice"><?= h($error) ?></p>
        <?php endif; ?>
      </section>

      <section>
        <h2>Nueva carga</h2>
        <form method="post" action="index.php" enctype="multipart/form-data">
          <input type="hidden" name="action" value="create" />
          <label>
            Tipo de contenido
            <select name="content_type">
              <?php foreach (CONTENT_TYPES as $type => $label): ?>
                <option value="<?= h($type) ?>"><?= h($label) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <label>
            Titulo
            <input name="title" required />
          </label>
          <label>
            Descripcion
            <textarea name="description"></textarea>
          </label>
          <label>
            Archivo
            <input name="upload" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.png,.jpg,.jpeg,.gif,.webp" />
          </label>
          <label class="inline-field">
            <input name="is_published" type="checkbox" checked />
            Publicar en el sitio
          </label>
          <button type="submit">Guardar contenido</button>
        </form>
      </section>

      <section>
        <h2>Contenido guardado</h2>
        <?php if ($items === []): ?>
          <p>Todavia no hay contenido guardado.</p>
        <?php else: ?>
          <table>
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Titulo</th>
                <th>Archivo</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td><?= h(content_type_label($item['content_type'])) ?></td>
                  <td><?= h($item['title']) ?></td>
                  <td>
                    <?php if (!empty($item['file_path'])): ?>
                      <a href="../<?= h($item['file_path']) ?>" target="_blank" rel="noopener"><?= h($item['original_filename'] ?: 'Ver archivo') ?></a>
                    <?php else: ?>
                      Sin archivo
                    <?php endif; ?>
                  </td>
                  <td><?= $item['is_published'] ? 'Publicado' : 'Borrador' ?></td>
                  <td>
                    <form method="post" action="index.php" onsubmit="return confirm('Eliminar este contenido?');">
                      <input type="hidden" name="action" value="delete" />
                      <input type="hidden" name="id" value="<?= (int) $item['id'] ?>" />
                      <button class="delete-button" type="submit">Eliminar</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </section>
    </main>
  </body>
</html>
