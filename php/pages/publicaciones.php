<?php
require_once __DIR__ . '/../includes/content.php';
$items = fetch_public_content(['publicacion', 'documento'], 20);
?>
<p class="page-kicker">Publicaciones</p>
<h1>Publicaciones</h1>
<p>
  Seccion preparada para articulos, produccion academica, comunicados y
  publicaciones de interes para la comunidad de posgrado.
</p>
<?php render_content_list($items); ?>
