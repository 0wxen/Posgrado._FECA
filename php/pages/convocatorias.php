<?php
require_once __DIR__ . '/../includes/content.php';
$items = fetch_public_content(['convocatoria'], 20);
?>

<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Convocatorias</h1>
    <p class="page-banner-desc">
      Consulta las convocatorias vigentes para admisión a los programas de posgrado,
      becas y actividades académicas de la División.
    </p>
  </div>
</section>

<!-- ===== CONVOCATORIAS ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Procesos activos</span>
      <h2>Convocatorias Vigentes</h2>
    </div>

    <?php if (!empty($items)): ?>
      <div class="noticias-grid">
        <?php foreach ($items as $item): ?>
          <article class="noticia-card">
            <div class="noticia-img">
              <?php if (!empty($item['file_path']) && str_starts_with((string)$item['mime_type'], 'image/')): ?>
                <img src="<?= h('../' . ltrim($item['file_path'], '/')) ?>"
                     alt="<?= h($item['title']) ?>">
              <?php else: ?>
                <i class="ti ti-file-certificate"></i>
              <?php endif; ?>
            </div>
            <div class="noticia-body">
              <span class="noticia-tag">Convocatoria</span>
              <h3><?= h($item['title']) ?></h3>
              <?php if (!empty($item['description'])): ?>
                <p><?= h(mb_strimwidth($item['description'], 0, 120, '…')) ?></p>
              <?php endif; ?>
              <?php if (!empty($item['file_path'])): ?>
                <a href="<?= h('../' . ltrim($item['file_path'], '/')) ?>"
                   target="_blank" rel="noopener" class="noticia-leer">
                  Descargar <i class="ti ti-download"></i>
                </a>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <!-- Placeholders cuando la base de datos no tiene convocatorias aún -->
      <div class="conv-grid">

        <div class="conv-card">
          <img src="../assets/img/convocatoria-a2025.png"
               class="conv-card-poster"
               alt="Convocatoria Ciclo A-2025">
          <div class="conv-card-body">
            <p class="conv-card-programa">Maestrías y Especialidad</p>
            <h3 class="conv-card-titulo">Convocatoria Ciclo A-2025</h3>
            <p class="conv-card-desc">
              La División de Estudios de Posgrado FECA UJED invita a los profesionistas
              egresados de licenciatura a participar en el proceso de admisión para el
              ciclo escolar A-2025.
            </p>
            <a href="../assets/img/convocatoria-a2025.png"
               target="_blank" rel="noopener"
               class="btn-sm-rojo">
              <i class="ti ti-download"></i> Descargar convocatoria
            </a>
          </div>
        </div>

        <div class="conv-card">
          <img src="../assets/img/convocatoria-me.png"
               class="conv-card-poster"
               alt="Convocatoria Maestría en Economía">
          <div class="conv-card-body">
            <p class="conv-card-programa">Maestría en Economía · PNPC</p>
            <h3 class="conv-card-titulo">Convocatoria ME 2025</h3>
            <p class="conv-card-desc">
              La Maestría en Economía, reconocida en el Padrón Nacional de Posgrados de
              Calidad (PNPC) de CONAHCYT, abre su proceso de selección para el ciclo 2025.
            </p>
            <a href="../assets/img/convocatoria-me.png"
               target="_blank" rel="noopener"
               class="btn-sm-rojo">
              <i class="ti ti-download"></i> Descargar convocatoria
            </a>
          </div>
        </div>

      </div>
    <?php endif; ?>

    <div style="margin-top:32px; padding:22px 24px; background:#f7f8fa; border-radius:4px; border-left:4px solid var(--dorado);">
      <strong style="display:block; margin-bottom:6px; font-size:15px;">¿Tienes dudas sobre el proceso de admisión?</strong>
      <p style="font-size:14px; margin:0; color:#555;">
        Contáctanos a <a href="mailto:posgradofeca@ujed.mx" style="color:var(--rojo);">posgradofeca@ujed.mx</a>
        o al <a href="tel:+526188271200" style="color:var(--rojo);">(618) 827 12 00 ext. 5430</a>.
        Atención de lunes a viernes, 8:00 a.m. – 3:00 p.m.
      </p>
    </div>

  </div>
</section>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#oferta_educativa" class="pnb-prev" data-page="oferta_educativa">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Ver</span>
        <span class="pnb-name">Oferta Educativa</span>
      </span>
    </a>
    <a href="#inicio" class="pnb-home" data-page="inicio" title="Volver a Inicio">
      <i class="ti ti-home"></i>
    </a>
    <a href="#contacto" class="pnb-next" data-page="contacto">
      <span class="pnb-info">
        <span class="pnb-dir">Ver</span>
        <span class="pnb-name">Contacto</span>
      </span>
      <span class="pnb-arrow"><i class="ti ti-arrow-right"></i></span>
    </a>
  </div>
</nav>
