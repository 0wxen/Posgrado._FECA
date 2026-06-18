<?php
require_once __DIR__ . '/../includes/content.php';
$items = fetch_public_content(['convocatoria'], 20);
?>
<p class="page-kicker">Convocatorias</p>
<h1>Convocatorias</h1>
<p>
  Aqui se concentran las convocatorias vigentes, documentos descargables,
  fechas importantes y requisitos de admision.
</p>
<?php render_content_list($items); ?>
