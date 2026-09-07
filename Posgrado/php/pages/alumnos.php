<?php
require_once __DIR__ . '/../includes/content.php';
require_once __DIR__ . '/../includes/alumnos.php';
?>
<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Área de Alumnos</h1>
    <p class="page-banner-desc">
      Formatos y procedimientos de trámites escolares, de acceso exclusivo para alumnado inscrito en la División.
    </p>
  </div>
</section>

<?php if (!alumno_autenticado()): ?>

  <!-- ===== CANDADO DE ACCESO ===== -->
  <section class="seccion seccion-gris">
    <div class="inner" style="max-width:440px; margin:0 auto;">
      <div class="contacto-form-card">
        <h3>Acceso para Alumnos</h3>
        <p style="color:#777; font-size:13.5px; margin:-8px 0 18px;">
          Pide la clave de acceso a la Coordinación Académica de tu programa.
        </p>

        <div id="alumnos-aviso" hidden style="margin-bottom:16px;padding:10px 14px;border-radius:4px;background:#fdecec;color:#951823;font-size:13px;font-weight:600;">
          La clave no es correcta. Vuelve a intentarlo.
        </div>

        <form action="/php/tools/alumnos_login.php" method="post">
          <div class="form-group">
            <label class="form-label" for="al-clave">Clave de acceso</label>
            <input type="password" id="al-clave" name="clave" class="form-control" placeholder="••••••••" required autofocus>
          </div>
          <button type="submit" class="btn-submit"><i class="ti ti-lock-open"></i> Entrar</button>
        </form>
      </div>
    </div>
  </section>

  <script>
  (function () {
    if (new URLSearchParams(window.location.search).get('error') === 'clave') {
      var a = document.getElementById('alumnos-aviso');
      if (a) a.hidden = false;
    }
  })();
  </script>

<?php else: ?>

  <!-- ===== DOCUMENTOS (ya autenticado) ===== -->
  <section class="seccion seccion-blanca">
    <div class="inner">

      <div style="display:flex; justify-content:flex-end; margin-bottom:8px;">
        <a href="/php/tools/alumnos_logout.php" class="btn-sm-outline"><i class="ti ti-logout"></i> Salir del área de Alumnos</a>
      </div>

      <div class="seccion-header">
        <span class="kicker">Asignación de Director de Tesis</span>
        <h2>Trámite ante tu Coordinación Académica</h2>
        <p>El procedimiento completo y la carta compromiso que firma el director propuesto.</p>
      </div>
      <div class="recursos-grid" style="margin-bottom:44px;">
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=asignacion_director_procedimiento">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Procedimiento de Asignación</h4><p>Criterios y pasos para que se te asigne director de tesis.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=asignacion_director_carta">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Carta Compromiso del Director</h4><p>Formato que firma tu director de tesis al aceptar dirigirte.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
      </div>

      <div class="seccion-header">
        <span class="kicker">Baja de Alumno</span>
        <h2>Baja Temporal o Definitiva</h2>
        <p>Toda solicitud de baja se presenta por escrito dentro de los plazos del calendario escolar vigente,
        ante tu Coordinación Académica. La baja temporal procede por causa justificada (salud, laboral, personal)
        y no puede exceder los periodos consecutivos que marca el Reglamento de Estudios de Posgrado.</p>
      </div>
      <div class="recursos-grid" style="margin-bottom:44px;">
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=baja_solicitud_definitiva">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Solicitud de Baja Definitiva</h4><p>Para dar por concluida tu inscripción al programa.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=baja_solicitud_temporal">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Solicitud de Baja Temporal</h4><p>Para pausar tu inscripción por un periodo y reincorporarte después.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
      </div>

      <div class="seccion-header">
        <span class="kicker">Titulación</span>
        <h2>Certificación y Trabajo Terminal</h2>
        <p>Formatos de ambas modalidades. La guía general de cada proceso está también disponible de forma pública
        en <a href="#titulacion" data-page="titulacion">Titulación por Certificación</a> y
        <a href="#trabajo_terminal" data-page="trabajo_terminal">Titulación por Trabajo Terminal</a>.</p>
      </div>
      <div class="recursos-grid" style="margin-bottom:44px;">
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=titulacion_certificacion_procedimiento">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Procedimiento — Titulación por Certificación</h4><p>Documento oficial del trámite completo.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=titulacion_tt_procedimiento">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Procedimiento — Titulación por Trabajo Terminal</h4><p>Documento oficial del trámite completo.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=titulacion_tt_carta">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Carta Compromiso del Director</h4><p>Para Trabajo Terminal.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=titulacion_tt_consentimiento">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Consentimiento de Publicación</h4><p>Autorización para publicar tu trabajo terminal.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=titulacion_tt_oficio">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Oficio de Liberación de Trabajo Terminal</h4><p>Lo emite el sínodo al aprobar tu documento final.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=titulacion_tt_portada">
          <div class="recurso-icon tipo-doc"><i class="ti ti-file-text"></i></div>
          <div class="recurso-info"><h4>Portada y Lineamientos de Entrega</h4><p>Formato oficial para la entrega de tu trabajo terminal.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
      </div>

      <div class="seccion-header">
        <span class="kicker">Referencia</span>
        <h2>Manual de Procedimientos Completo</h2>
        <p>Los 12 procesos institucionales de la División, por si necesitas ver el contexto completo de un trámite.</p>
      </div>
      <div class="recursos-grid">
        <a class="recurso-card" href="/php/tools/alumnos_descargar.php?f=manual_completo">
          <div class="recurso-icon tipo-pdf"><i class="ti ti-book"></i></div>
          <div class="recurso-info"><h4>Manual de Procedimientos DEP-FECA</h4><p>Documento completo, los 12 procedimientos.</p><span class="recurso-info-link"><i class="ti ti-download"></i> Descargar</span></div>
        </a>
      </div>

    </div>
  </section>

<?php endif; ?>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#comunidad" class="pnb-prev" data-page="comunidad">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Volver a</span>
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
