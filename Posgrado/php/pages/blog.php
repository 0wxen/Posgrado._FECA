<?php
require_once __DIR__ . '/../includes/content.php';
$items     = listar_blog(20);
$destacado = !empty($items) ? array_shift($items) : null;
$resto     = $items;
?>

<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Blog</h1>
    <p class="page-banner-desc">
      Noticias, comunicados, artículos y actualizaciones de la División de
      Estudios de Posgrado. Mantente informado.
    </p>
  </div>
</section>

<!-- ===== ENTRADA DESTACADA ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Lo más reciente</span>
      <h2>Entrada Destacada</h2>
    </div>

    <?php if ($destacado): ?>
    <div class="blog-featured">
      <div class="blog-featured-img">
        <?php if (!empty($destacado['imagen_url'])): ?>
          <img src="<?= h(url_subida($destacado['imagen_url'])) ?>"
               alt="<?= h($destacado['titulo']) ?>">
        <?php else: ?>
          <i class="ti ti-news"></i>
          <span>Imagen destacada</span>
        <?php endif; ?>
      </div>
      <div class="blog-featured-body">
        <span class="noticia-tag">Blog</span>
        <h2><?= h($destacado['titulo']) ?></h2>
        <?php if (!empty($destacado['resumen'])): ?>
          <p><?= h(mb_strimwidth($destacado['resumen'], 0, 200, '…')) ?></p>
        <?php endif; ?>
        <?php if (!empty($destacado['autor_nombre'])): ?>
          <p style="font-size:13px;color:#888;">Por <?= h($destacado['autor_nombre']) ?></p>
        <?php endif; ?>
      </div>
    </div>
    <?php else: ?>
    <div class="admin-empty">
      <i class="ti ti-news-off"></i>
      <p>Por el momento no hay entradas publicadas. Vuelve a consultar pronto.</p>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ===== TODAS LAS ENTRADAS ===== -->
<section class="seccion seccion-gris">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Archivo</span>
      <h2>Todas las Entradas</h2>
    </div>

    <div class="noticias-grid">

      <?php if (!empty($resto)): ?>
        <?php foreach ($resto as $item): ?>
          <article class="noticia-card">
            <div class="noticia-img">
              <?php if (!empty($item['imagen_url'])): ?>
                <img src="<?= h(url_subida($item['imagen_url'])) ?>"
                     alt="<?= h($item['titulo']) ?>">
              <?php else: ?>
                <i class="ti ti-news"></i>
              <?php endif; ?>
            </div>
            <div class="noticia-body">
              <span class="noticia-tag">Blog</span>
              <h3><?= h($item['titulo']) ?></h3>
              <?php if (!empty($item['resumen'])): ?>
                <p><?= h(mb_strimwidth($item['resumen'], 0, 100, '…')) ?></p>
              <?php endif; ?>
              <a href="#" class="noticia-leer">
                Leer más <i class="ti ti-arrow-right"></i>
              </a>
            </div>
          </article>
        <?php endforeach; ?>

      <?php else: ?>
        <div class="admin-empty">
          <i class="ti ti-news-off"></i>
          <p>Por el momento no hay más entradas. Vuelve a consultar pronto.</p>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#comunidad" class="pnb-prev" data-page="comunidad">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Anterior</span>
        <span class="pnb-name">Comunidad</span>
      </span>
    </a>
    <a href="#inicio" class="pnb-home" data-page="inicio" title="Volver a Inicio">
      <i class="ti ti-home"></i>
    </a>
    <a href="#contacto" class="pnb-next" data-page="contacto">
      <span class="pnb-info">
        <span class="pnb-dir">Siguiente</span>
        <span class="pnb-name">Contacto</span>
      </span>
      <span class="pnb-arrow"><i class="ti ti-arrow-right"></i></span>
    </a>
  </div>
</nav>
