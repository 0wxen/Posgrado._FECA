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
    <?php
      $modalDestacado = [
        'img'     => url_subida($destacado['imagen_url'] ?? null),
        'tag'     => 'Blog',
        'title'   => $destacado['titulo'],
        'fecha'   => !empty($destacado['fecha_evento']) ? $destacado['fecha_evento'] : (!empty($destacado['publicado_en']) ? substr($destacado['publicado_en'], 0, 10) : ''),
        'lugar'   => $destacado['lugar_evento'] ?? '',
        'autor'   => !empty($destacado['autor_nombre']) ? 'Por ' . $destacado['autor_nombre'] : '',
        'resumen' => $destacado['resumen'] ?? '',
        'cuerpo'  => $destacado['cuerpo'] ?? '',
      ];
      $modalDestacadoJson = modal_json($modalDestacado);
    ?>
    <div class="blog-featured noticia-clickable" tabindex="0" role="button"
         aria-label="Ver detalle: <?= h($destacado['titulo']) ?>"
         data-modal="<?= $modalDestacadoJson ?>">
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
        <span class="noticia-leer">
          Leer la nota completa <i class="ti ti-arrow-right"></i>
        </span>
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

    <?php if (!empty($resto)): ?>
      <div class="busqueda-filtros-row">
        <div class="busqueda-box">
          <i class="ti ti-search"></i>
          <input type="text" id="blog-buscar" placeholder="Buscar por título o resumen…">
        </div>
      </div>
    <?php endif; ?>

    <div class="noticias-grid" id="blog-grid">

      <?php if (!empty($resto)): ?>
        <?php foreach ($resto as $item): ?>
          <?php
            $modalItem = [
              'img'     => url_subida($item['imagen_url'] ?? null),
              'tag'     => 'Blog',
              'title'   => $item['titulo'],
              'fecha'   => !empty($item['fecha_evento']) ? $item['fecha_evento'] : (!empty($item['publicado_en']) ? substr($item['publicado_en'], 0, 10) : ''),
              'lugar'   => $item['lugar_evento'] ?? '',
              'autor'   => !empty($item['autor_nombre']) ? 'Por ' . $item['autor_nombre'] : '',
              'resumen' => $item['resumen'] ?? '',
              'cuerpo'  => $item['cuerpo'] ?? '',
            ];
            $modalItemJson = modal_json($modalItem);
          ?>
          <article class="noticia-card noticia-clickable" tabindex="0" role="button"
                    aria-label="Ver detalle: <?= h($item['titulo']) ?>"
                    data-modal="<?= $modalItemJson ?>">
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
              <span class="noticia-leer">
                Leer más <i class="ti ti-arrow-right"></i>
              </span>
            </div>
          </article>
        <?php endforeach; ?>
        <div class="busqueda-sin-resultados" id="blog-sin-resultados" hidden>
          <i class="ti ti-search-off"></i>
          No hay entradas que coincidan con tu búsqueda.
        </div>

      <?php else: ?>
        <div class="admin-empty">
          <i class="ti ti-news-off"></i>
          <p>Por el momento no hay más entradas. Vuelve a consultar pronto.</p>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>

<script>
(function () {
  document.querySelectorAll('.noticia-clickable[data-modal]').forEach(function (card) {
    var abrir = function () {
      var data = {};
      try { data = JSON.parse(card.dataset.modal || '{}'); } catch (_) {}
      if (typeof window.openNoticiaModal === 'function') window.openNoticiaModal(data);
    };
    card.addEventListener('click', abrir);
    card.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); abrir(); }
    });
  });

  var input     = document.getElementById('blog-buscar');
  var grid      = document.getElementById('blog-grid');
  var sinResult = document.getElementById('blog-sin-resultados');
  if (!input || !grid) return;
  var cards = grid.querySelectorAll('.noticia-card');

  input.addEventListener('input', function () {
    var texto = input.value.trim().toLowerCase();
    var visibles = 0;
    cards.forEach(function (card) {
      var visible = texto === '' || card.textContent.toLowerCase().indexOf(texto) !== -1;
      card.style.display = visible ? '' : 'none';
      if (visible) visibles++;
    });
    if (sinResult) sinResult.hidden = visibles !== 0;
  });
})();
</script>

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
