<?php
require_once __DIR__ . '/../includes/content.php';
$documentos_db = listar_documentos();
?>
<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Transparencia</h1>
    <p class="page-banner-desc">
      Información pública y documentos institucionales conforme a las obligaciones
      de transparencia de la Universidad Juárez del Estado de Durango.
    </p>
  </div>
</section>

<!-- ===== DOCUMENTOS Y RECURSOS ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Acceso a la información pública</span>
      <h2>Información Institucional</h2>
      <p>La UJED y sus dependencias académicas están sujetas a la Ley de Acceso a la
         Información Pública y Protección de Datos Personales del Estado de Durango.</p>
    </div>

    <div class="recursos-grid">

      <a class="recurso-card" href="https://www.ujed.mx" target="_blank" rel="noopener">
        <div class="recurso-icon tipo-link"><i class="ti ti-world"></i></div>
        <div class="recurso-info">
          <h4>Portal de Transparencia UJED</h4>
          <p>Accede al portal institucional de transparencia y solicitudes de información de la UJED.</p>
          <span class="recurso-info-link"><i class="ti ti-external-link"></i> Ir al portal</span>
        </div>
      </a>

      <a class="recurso-card" href="https://www.ujed.mx" target="_blank" rel="noopener">
        <div class="recurso-icon tipo-link"><i class="ti ti-scale"></i></div>
        <div class="recurso-info">
          <h4>Marco Normativo</h4>
          <p>Reglamentos, estatutos y disposiciones legales que rigen a la División y a la UJED.</p>
          <span class="recurso-info-link"><i class="ti ti-external-link"></i> Ver normatividad</span>
        </div>
      </a>

      <a class="recurso-card" href="#inicio" data-page="inicio">
        <div class="recurso-icon tipo-link"><i class="ti ti-building"></i></div>
        <div class="recurso-info">
          <h4>Página Principal FECA</h4>
          <p>Consulta la normatividad y demás información institucional en el sitio oficial de la FECA UJED.</p>
          <span class="recurso-info-link"><i class="ti ti-home"></i> Ir a Inicio</span>
        </div>
      </a>

      <a class="recurso-card" href="mailto:posgradofeca@ujed.mx">
        <div class="recurso-icon tipo-link"><i class="ti ti-mail"></i></div>
        <div class="recurso-info">
          <h4>Solicitudes de Acceso a la Información</h4>
          <p>Para realizar una solicitud formal de información, comunícate con la coordinación de la División.</p>
          <span class="recurso-info-link"><i class="ti ti-mail"></i> Enviar solicitud</span>
        </div>
      </a>

      <a class="recurso-card" href="#">
        <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
        <div class="recurso-info">
          <h4>Presupuesto y Ejercicio del Gasto</h4>
          <p>Información sobre el presupuesto asignado y el ejercicio del gasto de la División.</p>
          <span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span>
        </div>
      </a>

      <a class="recurso-card" href="#">
        <div class="recurso-icon tipo-pdf"><i class="ti ti-file-type-pdf"></i></div>
        <div class="recurso-info">
          <h4>Plan de Desarrollo Institucional</h4>
          <p>Documento rector con los objetivos estratégicos de la División de Estudios de Posgrado.</p>
          <span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span>
        </div>
      </a>

      <a class="recurso-card" href="#nosotros" data-page="nosotros">
        <div class="recurso-icon tipo-pdf"><i class="ti ti-file-type-pdf"></i></div>
        <div class="recurso-info">
          <h4>Directorio de Personal</h4>
          <p>Listado de docentes, investigadores y personal administrativo de la División.</p>
          <span class="recurso-info-link"><i class="ti ti-arrow-right"></i> Ver directorio</span>
        </div>
      </a>

      <?php foreach ($documentos_db as $doc): ?>
        <a class="recurso-card" href="<?= !empty($doc['archivo_url']) ? h(url_subida($doc['archivo_url'])) : '#' ?>" target="_blank" rel="noopener">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info">
            <h4><?= h($doc['titulo']) ?></h4>
            <?php if (!empty($doc['descripcion'])): ?><p><?= h($doc['descripcion']) ?></p><?php endif; ?>
            <span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span>
          </div>
        </a>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#inicio" class="pnb-prev" data-page="inicio">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Ir a</span>
        <span class="pnb-name">Inicio</span>
      </span>
    </a>
    <a href="#inicio" class="pnb-home" data-page="inicio" title="Volver a Inicio">
      <i class="ti ti-home"></i>
    </a>
    <a href="#mapa_sitio" class="pnb-next" data-page="mapa_sitio">
      <span class="pnb-info">
        <span class="pnb-dir">Ver</span>
        <span class="pnb-name">Mapa del Sitio</span>
      </span>
      <span class="pnb-arrow"><i class="ti ti-arrow-right"></i></span>
    </a>
  </div>
</nav>
