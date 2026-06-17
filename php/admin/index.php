<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/auth.php';
require_admin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $message = 'La estructura de carga ya está lista. Falta conectar este formulario con PostgreSQL y definir qué tipo de contenido se va a subir.';
}
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de cargas · Posgrado FECA</title>
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
        width: min(980px, calc(100% - 32px));
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

      .notice {
        color: #951823;
        font-weight: 700;
      }
    </style>
  </head>
  <body>
    <header>
      <strong>Panel de cargas</strong>
      <nav>
        <a href="../principal.php?page=inicio">Ver sitio</a>
        <span aria-hidden="true"> · </span>
        <a href="logout.php">Salir</a>
      </nav>
    </header>

    <main>
      <section>
        <h1>Contenido para publicar</h1>
        <p>
          Este apartado queda separado del sitio principal y protegido por credenciales.
          Aquí después conectaremos PostgreSQL para guardar noticias, convocatorias,
          documentos o imágenes.
        </p>
        <?php if ($message): ?>
          <p class="notice"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
      </section>

      <section>
        <h2>Nueva carga</h2>
        <form method="post" action="index.php" enctype="multipart/form-data">
          <label>
            Tipo de contenido
            <select name="content_type">
              <option value="noticia">Noticia</option>
              <option value="convocatoria">Convocatoria</option>
              <option value="documento">Documento</option>
              <option value="imagen">Imagen</option>
            </select>
          </label>
          <label>
            Título
            <input name="title" required />
          </label>
          <label>
            Descripción
            <textarea name="description"></textarea>
          </label>
          <label>
            Archivo
            <input name="upload" type="file" />
          </label>
          <button type="submit">Preparar carga</button>
        </form>
      </section>
    </main>
  </body>
</html>
