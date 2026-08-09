<?php
require_once __DIR__ . '/../includes/content.php';
$items = listar_publicaciones();
?>

<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Publicaciones</h1>
    <p class="page-banner-desc">
      Producción académica de los investigadores y cuerpos académicos de la División:
      artículos, libros, capítulos de libro y memorias de congreso.
    </p>
  </div>
</section>

<!-- ===== PUBLICACIONES ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Producción académica</span>
      <h2>Publicaciones y Documentos</h2>
    </div>

    <div class="noticias-grid">
      <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
          <article class="noticia-card">
            <div class="noticia-img"><i class="ti ti-book-2"></i></div>
            <div class="noticia-body">
              <span class="noticia-tag"><?= h(ucfirst($item['tipo'] ?? 'Publicación')) ?></span>
              <h3><?= h($item['titulo']) ?></h3>
              <p>
                <?= h($item['autores_texto']) ?><?php if (!empty($item['revista_editorial'])): ?> · <?= h($item['revista_editorial']) ?><?php endif; ?><?php if (!empty($item['anio'])): ?> · <?= (int) $item['anio'] ?><?php endif; ?>
              </p>
              <?php if (!empty($item['archivo_url'])): ?>
                <a href="<?= h(url_subida($item['archivo_url'])) ?>"
                   target="_blank" rel="noopener" class="noticia-leer">
                  Descargar <i class="ti ti-download"></i>
                </a>
              <?php elseif (!empty($item['url_externo'])): ?>
                <a href="<?= h($item['url_externo']) ?>" target="_blank" rel="noopener" class="noticia-leer">
                  Ver publicación <i class="ti ti-external-link"></i>
                </a>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>

      <?php else: ?>
        <div class="admin-empty">
          <i class="ti ti-book-off"></i>
          <p>Por el momento no hay publicaciones registradas. Vuelve a consultar pronto.</p>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#investigacion" class="pnb-prev" data-page="investigacion">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Volver a</span>
        <span class="pnb-name">Investigación</span>
      </span>
    </a>
    <a href="#inicio" class="pnb-home" data-page="inicio" title="Volver a Inicio">
      <i class="ti ti-home"></i>
    </a>
    <a href="#comunidad" class="pnb-next" data-page="comunidad">
      <span class="pnb-info">
        <span class="pnb-dir">Ver</span>
        <span class="pnb-name">Comunidad</span>
      </span>
      <span class="pnb-arrow"><i class="ti ti-arrow-right"></i></span>
    </a>
  </div>
</nav>
