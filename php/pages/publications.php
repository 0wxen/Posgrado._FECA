<?php
require_once __DIR__ . '/../includes/content.php';
$items = fetch_public_content(['publicacion', 'documento'], 20);
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
            <div class="noticia-img">
              <?php if (!empty($item['file_path']) && str_starts_with((string)$item['mime_type'], 'image/')): ?>
                <img src="<?= h('../' . ltrim($item['file_path'], '/')) ?>"
                     alt="<?= h($item['title']) ?>">
              <?php else: ?>
                <i class="ti ti-book-2"></i>
              <?php endif; ?>
            </div>
            <div class="noticia-body">
              <span class="noticia-tag"><?= h(ucfirst($item['content_type'] ?? 'Publicación')) ?></span>
              <h3><?= h($item['title']) ?></h3>
              <?php if (!empty($item['description'])): ?>
                <p><?= h(mb_strimwidth($item['description'], 0, 120, '…')) ?></p>
              <?php endif; ?>
              <?php if (!empty($item['file_path'])): ?>
                <a href="<?= h('../' . ltrim($item['file_path'], '/')) ?>"
                   target="_blank" rel="noopener" class="noticia-leer">
                  Descargar <i class="ti ti-download"></i>
                </a>
              <?php else: ?>
                <a href="#" class="noticia-leer">Ver más <i class="ti ti-arrow-right"></i></a>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>

      <?php else: ?>
        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-book-2"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Artículo</span>
            <h3>Impacto de la política fiscal en el crecimiento económico regional</h3>
            <p>Revista de Economía y Administración · Vol. 12 · 2024</p>
            <a href="#" class="noticia-leer">Ver más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>
        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-book-2"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Capítulo de libro</span>
            <h3>Gestión pública y transparencia: retos para el norte de México</h3>
            <p>Compilación Iberoamericana de Administración Pública · 2024</p>
            <a href="#" class="noticia-leer">Ver más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>
        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-book-2"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Memorias</span>
            <h3>Innovación en negocios: estrategias para el mercado duranguense</h3>
            <p>Congreso Internacional de Gestión · Durango, 2023</p>
            <a href="#" class="noticia-leer">Ver más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>
        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-book-2"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Artículo</span>
            <h3>Modelos de auditoría en el sector público: evidencia empírica</h3>
            <p>Revista Contaduría y Administración · UNAM · 2023</p>
            <a href="#" class="noticia-leer">Ver más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>
        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-book-2"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Artículo</span>
            <h3>Capital humano y competitividad empresarial en Durango</h3>
            <p>Revista Internacional de Administración y Finanzas · Vol. 16 · 2024</p>
            <a href="#" class="noticia-leer">Ver más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>
        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-book-2"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Libro</span>
            <h3>Finanzas empresariales en contextos emergentes</h3>
            <p>Editorial Universitaria UJED · 2023</p>
            <a href="#" class="noticia-leer">Ver más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>
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
