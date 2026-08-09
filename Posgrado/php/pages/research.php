<?php
require_once __DIR__ . '/../includes/content.php';
$publicaciones = array_slice(listar_publicaciones(), 0, 6);
?>

<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Investigación</h1>
    <p class="page-banner-desc">
      Generamos conocimiento con impacto regional y nacional a través de nuestros
      cuerpos académicos, grupos disciplinares y producción científica.
    </p>
  </div>
</section>

<!-- ===== 3 CAJAS DE ACCIÓN ===== -->
<div class="invest-grid">

  <a class="invest-card" href="https://cadepfeca.ujed.mx/cuerpos-academicos/gestion-y-desarrollo-de-las-organizaciones" target="_blank" rel="noopener">
    <i class="ti ti-users invest-card-icon"></i>
    <h2>Cuerpos Académicos</h2>
    <p>
      Grupos de profesores-investigadores que comparten una o más Líneas de
      Generación y Aplicación del Conocimiento (LGAC) en temas disciplinares
      afines. Consulta los cuerpos activos, sus integrantes y sus líneas de trabajo.
    </p>
    <span class="invest-card-cta">
      Explorar cuerpos <i class="ti ti-arrow-right"></i>
    </span>
  </a>

  <a class="invest-card" href="#grupos_disciplinares" data-page="grupos_disciplinares">
    <i class="ti ti-microscope invest-card-icon"></i>
    <h2>Grupos Disciplinares</h2>
    <p>
      Equipos de trabajo enfocados en líneas de investigación específicas que
      enriquecen la actividad académica y fortalecen los programas de posgrado.
      Conoce sus proyectos en desarrollo y resultados recientes.
    </p>
    <span class="invest-card-cta">
      Ver grupos <i class="ti ti-arrow-right"></i>
    </span>
  </a>

  <a class="invest-card" href="#publicaciones" data-page="publicaciones">
    <i class="ti ti-book-2 invest-card-icon"></i>
    <h2>Publicaciones</h2>
    <p>
      Artículos, libros, capítulos y memorias de congreso producidos por los
      investigadores de la División. Una muestra del compromiso con la generación
      de conocimiento riguroso y de alto impacto.
    </p>
    <span class="invest-card-cta">
      Ver publicaciones <i class="ti ti-arrow-right"></i>
    </span>
  </a>

</div>

<!-- ===== PUBLICACIONES RECIENTES ===== -->
<?php if (!empty($publicaciones)): ?>
<section class="seccion seccion-gris">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Producción académica</span>
      <h2>Publicaciones Recientes</h2>
    </div>
    <div class="noticias-grid">
      <?php foreach ($publicaciones as $pub): ?>
        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-book-2"></i></div>
          <div class="noticia-body">
            <span class="noticia-tag"><?= h(ucfirst($pub['tipo'] ?? 'Publicación')) ?></span>
            <h3><?= h($pub['titulo']) ?></h3>
            <p><?= h(mb_strimwidth($pub['autores_texto'], 0, 110, '…')) ?></p>
            <?php if (!empty($pub['archivo_url'])): ?>
              <a href="<?= h(url_subida($pub['archivo_url'])) ?>"
                 target="_blank" rel="noopener" class="noticia-leer">
                Descargar <i class="ti ti-download"></i>
              </a>
            <?php else: ?>
              <a href="#publicaciones" class="noticia-leer" data-page="publicaciones">
                Ver más <i class="ti ti-arrow-right"></i>
              </a>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="seccion-cta">
      <a href="#publicaciones" class="btn-link-rojo" data-page="publicaciones">
        Ver todas las publicaciones <i class="ti ti-arrow-right"></i>
      </a>
    </div>
  </div>
</section>
<?php else: ?>
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Producción académica</span>
      <h2>Publicaciones Recientes</h2>
    </div>
    <div class="admin-empty">
      <i class="ti ti-book-off"></i>
      <p>Por el momento no hay publicaciones registradas. Vuelve a consultar pronto.</p>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#oferta_educativa" class="pnb-prev" data-page="oferta_educativa">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Anterior</span>
        <span class="pnb-name">Oferta Educativa</span>
      </span>
    </a>
    <a href="#inicio" class="pnb-home" data-page="inicio" title="Volver a Inicio">
      <i class="ti ti-home"></i>
    </a>
    <a href="#comunidad" class="pnb-next" data-page="comunidad">
      <span class="pnb-info">
        <span class="pnb-dir">Siguiente</span>
        <span class="pnb-name">Comunidad</span>
      </span>
      <span class="pnb-arrow"><i class="ti ti-arrow-right"></i></span>
    </a>
  </div>
</nav>
