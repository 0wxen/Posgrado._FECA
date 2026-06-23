<?php
require_once __DIR__ . '/../includes/content.php';
$items     = fetch_public_content(['noticia', 'publicacion'], 20);
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
        <?php if (!empty($destacado['file_path']) && str_starts_with((string)$destacado['mime_type'], 'image/')): ?>
          <img src="<?= h('../' . ltrim($destacado['file_path'], '/')) ?>"
               alt="<?= h($destacado['title']) ?>">
        <?php else: ?>
          <i class="ti ti-news"></i>
          <span>Imagen destacada</span>
        <?php endif; ?>
      </div>
      <div class="blog-featured-body">
        <span class="noticia-tag"><?= h(ucfirst($destacado['content_type'] ?? 'Noticia')) ?></span>
        <h2><?= h($destacado['title']) ?></h2>
        <?php if (!empty($destacado['description'])): ?>
          <p><?= h(mb_strimwidth($destacado['description'], 0, 200, '…')) ?></p>
        <?php endif; ?>
        <?php if (!empty($destacado['file_path'])): ?>
          <a href="<?= h('../' . ltrim($destacado['file_path'], '/')) ?>"
             target="_blank" rel="noopener" class="btn-sm-rojo" style="margin-top:8px;">
            <i class="ti ti-download"></i> Ver archivo
          </a>
        <?php endif; ?>
      </div>
    </div>
    <?php else: ?>
    <div class="blog-featured">
      <div class="blog-featured-img">
        <img src="../assets/img/blog-destacado.jpg" alt="Entrada destacada del Blog">
      </div>
      <div class="blog-featured-body">
        <span class="noticia-tag">Noticia</span>
        <h2>Abierta la convocatoria de admisión Ciclo A-2025</h2>
        <p>
          La División de Estudios de Posgrado FECA UJED anuncia la apertura del proceso de
          admisión para el ciclo escolar A-2025 en sus programas de maestría y especialidad.
          Los interesados pueden descargar la convocatoria y consultar los requisitos de admisión.
        </p>
        <a href="#convocatorias" class="btn-sm-rojo" data-page="convocatorias" style="margin-top:8px;">
          <i class="ti ti-file-text"></i> Ver convocatoria
        </a>
      </div>
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
              <?php if (!empty($item['file_path']) && str_starts_with((string)$item['mime_type'], 'image/')): ?>
                <img src="<?= h('../' . ltrim($item['file_path'], '/')) ?>"
                     alt="<?= h($item['title']) ?>">
              <?php else: ?>
                <i class="ti ti-news"></i>
              <?php endif; ?>
            </div>
            <div class="noticia-body">
              <span class="noticia-tag"><?= h(ucfirst($item['content_type'] ?? 'Noticia')) ?></span>
              <h3><?= h($item['title']) ?></h3>
              <?php if (!empty($item['description'])): ?>
                <p><?= h(mb_strimwidth($item['description'], 0, 100, '…')) ?></p>
              <?php endif; ?>
              <?php if (!empty($item['file_path'])): ?>
                <a href="<?= h('../' . ltrim($item['file_path'], '/')) ?>"
                   target="_blank" rel="noopener" class="noticia-leer">
                  Ver archivo <i class="ti ti-download"></i>
                </a>
              <?php else: ?>
                <a href="#" class="noticia-leer">
                  Leer más <i class="ti ti-arrow-right"></i>
                </a>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>

      <?php else: ?>

        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-news"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Noticia</span>
            <h3>Maestría en Economía reconocida en el PNPC-CONAHCYT</h3>
            <p>El programa mantiene su reconocimiento dentro del Padrón Nacional de Posgrados de Calidad.</p>
            <a href="#" class="noticia-leer">Leer más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>

        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-news"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Evento</span>
            <h3>Conferencia Internacional de Gestión Pública en la FECA</h3>
            <p>La División fue sede del encuentro académico con ponentes de México, Colombia y España.</p>
            <a href="#" class="noticia-leer">Leer más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>

        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-news"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Aviso</span>
            <h3>Actualización de fechas: entrega de tesis ciclo A-2025</h3>
            <p>Nuevas fechas para la entrega y defensa de tesis para alumnos próximos a titularse.</p>
            <a href="#" class="noticia-leer">Leer más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>

        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-news"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Investigación</span>
            <h3>Publicación en revista indexada por docentes del Cuerpo Académico</h3>
            <p>Investigadores del CA-FECA publican artículo sobre finanzas públicas en revista de alto impacto.</p>
            <a href="#investigacion" class="noticia-leer" data-page="investigacion">
              Ver publicaciones <i class="ti ti-arrow-right"></i>
            </a>
          </div>
        </article>

        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-news"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Convocatoria</span>
            <h3>Convocatoria para el Doctorado en Gestión de las Organizaciones</h3>
            <p>La División abre proceso de admisión para el programa doctoral. Revisa requisitos y fechas.</p>
            <a href="#convocatorias" class="noticia-leer" data-page="convocatorias">
              Ver convocatoria <i class="ti ti-arrow-right"></i>
            </a>
          </div>
        </article>

        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-news"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag">Comunidad</span>
            <h3>Egresados distinguidos del Posgrado FECA en puestos directivos</h3>
            <p>Reconocemos a egresados que ocupan cargos de alto impacto en el sector público y privado de Durango.</p>
            <a href="#" class="noticia-leer">Leer más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>

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
