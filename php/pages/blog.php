<?php
require_once __DIR__ . '/../includes/content.php';
$items = fetch_public_content(['noticia', 'publicacion'], 20);
?>
<p class="page-kicker">Blog</p>
<h1>Noticias y publicaciones</h1>
<p>
  Aqui puedes consultar noticias, comunicados, articulos breves y actualizaciones
  de la Division de Estudios de Posgrado.
</p>
<h2>Entradas recientes</h2>
<?php render_content_list($items); ?>
