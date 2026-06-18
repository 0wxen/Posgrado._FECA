<?php
require_once __DIR__ . '/../includes/content.php';
$latestItems = fetch_public_content(['noticia', 'convocatoria', 'publicacion', 'documento', 'imagen'], 6);
?>
<p class="page-kicker">Inicio</p>
<h1>Division de Estudios de Posgrado FECA</h1>
<p>
  La herramienta para el futuro que tu deseas. Consulta convocatorias,
  noticias, documentos e imagenes publicados por la Division de Estudios de
  Posgrado de la Facultad de Economia, Contaduria y Administracion.
</p>
<h2>Contenido reciente</h2>
<?php render_content_list($latestItems); ?>
