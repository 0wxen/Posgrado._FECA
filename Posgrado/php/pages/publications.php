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

    <?php if (!empty($items)): ?>
      <div class="busqueda-filtros-row">
        <div class="busqueda-box">
          <i class="ti ti-search"></i>
          <input type="text" id="publicaciones-buscar" placeholder="Buscar por título, autor o revista…">
        </div>
        <div class="busqueda-tabs" id="publicaciones-tabs">
          <button class="busqueda-tab activo" data-tipo="todos">Todos</button>
          <button class="busqueda-tab" data-tipo="articulo">Artículo</button>
          <button class="busqueda-tab" data-tipo="capitulo">Capítulo de libro</button>
          <button class="busqueda-tab" data-tipo="libro">Libro</button>
          <button class="busqueda-tab" data-tipo="memoria">Memoria de congreso</button>
          <button class="busqueda-tab" data-tipo="otro">Otro</button>
        </div>
      </div>
    <?php endif; ?>

    <div class="noticias-grid" id="publicaciones-grid">
      <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
          <article class="noticia-card noticia-clickable" tabindex="0" role="button"
                    aria-label="Ver detalle: <?= h($item['titulo']) ?>"
                    data-tipo="<?= h($item['tipo'] ?? 'otro') ?>"
                    data-modal="<?= modal_json(modal_data_publicacion($item)) ?>">
            <div class="noticia-img">
              <?php if (!empty($item['imagen_url'])): ?>
                <img src="<?= h(url_subida($item['imagen_url'])) ?>" alt="<?= h($item['titulo']) ?>">
              <?php else: ?>
                <i class="ti ti-book-2"></i>
              <?php endif; ?>
            </div>
            <div class="noticia-body">
              <span class="noticia-tag"><?= h(ucfirst($item['tipo'] ?? 'Publicación')) ?></span>
              <h3><?= h($item['titulo']) ?></h3>
              <p>
                <?= h($item['autores_texto']) ?><?php if (!empty($item['revista_editorial'])): ?> · <?= h($item['revista_editorial']) ?><?php endif; ?><?php if (!empty($item['anio'])): ?> · <?= (int) $item['anio'] ?><?php endif; ?>
              </p>
              <span class="noticia-leer">
                Ver detalles <i class="ti ti-arrow-right"></i>
              </span>
            </div>
          </article>
        <?php endforeach; ?>
        <div class="busqueda-sin-resultados" id="publicaciones-sin-resultados" hidden>
          <i class="ti ti-search-off"></i>
          No hay publicaciones que coincidan con tu búsqueda.
        </div>

      <?php else: ?>
        <div class="admin-empty">
          <i class="ti ti-book-off"></i>
          <p>Por el momento no hay publicaciones registradas. Vuelve a consultar pronto.</p>
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

  var input      = document.getElementById('publicaciones-buscar');
  var tabs       = document.querySelectorAll('#publicaciones-tabs [data-tipo]');
  var grid       = document.getElementById('publicaciones-grid');
  var sinResult  = document.getElementById('publicaciones-sin-resultados');
  if (!input || !grid) return;
  var cards = grid.querySelectorAll('.noticia-card[data-tipo]');
  var tipoActivo = 'todos';

  function aplicarFiltro() {
    var texto = input.value.trim().toLowerCase();
    var visibles = 0;
    cards.forEach(function (card) {
      var coincideTipo   = tipoActivo === 'todos' || card.dataset.tipo === tipoActivo;
      var coincideTexto  = texto === '' || card.textContent.toLowerCase().indexOf(texto) !== -1;
      var visible = coincideTipo && coincideTexto;
      card.style.display = visible ? '' : 'none';
      if (visible) visibles++;
    });
    if (sinResult) sinResult.hidden = visibles !== 0;
  }

  input.addEventListener('input', aplicarFiltro);
  tabs.forEach(function (btn) {
    btn.addEventListener('click', function () {
      tabs.forEach(function (b) { b.classList.remove('activo'); });
      btn.classList.add('activo');
      tipoActivo = btn.dataset.tipo;
      aplicarFiltro();
    });
  });
})();
</script>

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
