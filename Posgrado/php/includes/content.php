<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

const CONTENT_TYPES = [
  'noticia' => 'Noticia',
  'convocatoria' => 'Convocatoria',
  'documento' => 'Documento',
  'imagen' => 'Imagen',
  'publicacion' => 'Publicacion',
];

function h(?string $value): string {
  return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function content_type_label(string $type): string {
  return CONTENT_TYPES[$type] ?? $type;
}

function fetch_public_content(array $types, int $limit = 20): array {
  global $pdo;

  if ($pdo === null || $types === []) {
    return [];
  }

  $placeholders = implode(', ', array_fill(0, count($types), '?'));
  $sql = "
    SELECT id, content_type, title, description, file_path, original_filename, mime_type, file_size, created_at
    FROM content_items
    WHERE is_published = TRUE
      AND content_type IN ($placeholders)
    ORDER BY created_at DESC
    LIMIT ?
  ";

  $statement = $pdo->prepare($sql);
  $index = 1;

  foreach ($types as $type) {
    $statement->bindValue($index, $type);
    $index++;
  }

  $statement->bindValue($index, $limit, PDO::PARAM_INT);
  $statement->execute();

  return $statement->fetchAll();
}

function render_content_list(array $items): void {
  if ($items === []) {
    echo '<p>Por el momento no hay contenido publicado en esta seccion.</p>';
    return;
  }

  echo '<div class="content-list">';

  foreach ($items as $item) {
    echo '<article class="content-card">';
    echo '<p class="page-kicker">' . h(content_type_label($item['content_type'])) . '</p>';
    echo '<h2>' . h($item['title']) . '</h2>';

    if (!empty($item['description'])) {
      echo '<p>' . nl2br(h($item['description'])) . '</p>';
    }

    if (!empty($item['file_path'])) {
      $fileUrl = h('../' . ltrim($item['file_path'], '/'));
      $fileName = h($item['original_filename'] ?: 'Descargar archivo');

      if (str_starts_with((string) $item['mime_type'], 'image/')) {
        echo '<img class="content-image" src="' . $fileUrl . '" alt="' . h($item['title']) . '" />';
      }

      echo '<p><a class="content-file-link" href="' . $fileUrl . '" target="_blank" rel="noopener">Ver archivo: ' . $fileName . '</a></p>';
    }

    echo '</article>';
  }

  echo '</div>';
}
?>
