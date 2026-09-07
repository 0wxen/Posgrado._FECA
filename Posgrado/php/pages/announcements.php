<?php
require_once __DIR__ . '/../includes/content.php';
$items = listar_convocatorias();
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

<!-- ===== CONVOCATORIAS VIGENTES ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">

    <div class="conv-section-title">
      <h3>Convocatorias Abiertas</h3>
      <span class="conv-vigente-badge">
        <i class="ti ti-circle-filled"></i>
        Proceso activo
      </span>
    </div>

    <?php if (!empty($items)): ?>
      <div class="conv-vigentes-grid">
        <?php foreach ($items as $item): ?>
          <?php
            $modalData = [
              'img'        => url_subida($item['imagen_url'] ?? null),
              'badge'      => 'Ciclo ' . ($item['ciclo'] ?? ''),
              'title'      => $item['titulo'],
              'ciclo'      => $item['ciclo'] ?? '',
              'limite'     => !empty($item['fecha_cierre']) ? 'Cierre: ' . $item['fecha_cierre'] : '',
              'desc'       => $item['descripcion'] ?? '',
              'requisitos' => $item['requisitos'] ?? '',
              'programa'   => !empty($item['programa_codigo']) ? 'program_' . strtolower($item['programa_codigo']) : '',
              'doc'        => url_subida($item['archivo_url'] ?? null),
            ];
            $modalJson = modal_json($modalData);
          ?>
          <div class="conv-card-vigente" data-cierre="<?= h($item['fecha_cierre'] ?? '') ?>" data-modal="<?= $modalJson ?>">
            <?php if (!empty($item['imagen_url'])): ?>
              <img class="conv-card-vigente-img" src="<?= h(url_subida($item['imagen_url'])) ?>" alt="<?= h($item['titulo']) ?>">
            <?php else: ?>
              <div class="conv-card-vigente-img-placeholder"><i class="ti ti-file-text"></i></div>
            <?php endif; ?>
            <div class="conv-card-vigente-body">
              <span class="conv-vigente-badge conv-vigente-badge--sm"><i class="ti ti-circle-filled"></i> <?= h($item['ciclo'] ?? '') ?></span>
              <h3><?= h($item['titulo']) ?></h3>
              <?php if (!empty($item['fecha_cierre'])): ?>
                <div class="conv-card-vigente-fecha">
                  <i class="ti ti-calendar"></i>
                  Cierre de convocatoria: <?= h($item['fecha_cierre']) ?>
                </div>
              <?php endif; ?>
              <?php if (!empty($item['descripcion'])): ?>
                <p><?= h(mb_strimwidth($item['descripcion'], 0, 140, '…')) ?></p>
              <?php endif; ?>
            </div>
            <div class="conv-card-vigente-footer">
              <button class="btn-sm-rojo conv-ver-detalles" type="button">
                <i class="ti ti-info-circle"></i> Ver detalles
              </button>
              <?php if (!empty($item['archivo_url'])): ?>
                <a href="<?= h(url_subida($item['archivo_url'])) ?>" target="_blank" rel="noopener" class="btn-sm-outline">
                  <i class="ti ti-download"></i> Descargar PDF
                </a>
              <?php endif; ?>
              <?php if (!empty($item['imagen_url'])): ?>
                <a href="<?= h(url_subida($item['imagen_url'])) ?>" download target="_blank" rel="noopener" class="btn-sm-outline">
                  <i class="ti ti-photo-down"></i> Descargar imagen
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- ===== CONVOCATORIAS CERRADAS (auto-visible al vencer) ===== -->
      <div id="conv-cerradas-section" hidden class="conv-bloque-extra">
        <div class="conv-section-title">
          <h3 class="conv-cerradas-titulo">Convocatorias Cerradas</h3>
          <span class="conv-cerradas-badge">
            <i class="ti ti-lock"></i> Proceso finalizado
          </span>
        </div>
        <div class="conv-vigentes-grid" id="conv-cerradas-grid"></div>
      </div>

      <script>
      (function () {
        var hoy = new Date();
        hoy.setHours(0, 0, 0, 0);

        var vigsGrid    = document.querySelector('.conv-vigentes-grid');
        var cerradasSec = document.getElementById('conv-cerradas-section');
        var cerradasGrid= document.getElementById('conv-cerradas-grid');

        if (vigsGrid && cerradasGrid) {
          var cards = Array.from(vigsGrid.querySelectorAll('.conv-card-vigente'));
          var hayCerradas = false;

          cards.forEach(function (card) {
            var cierre = card.dataset.cierre ? new Date(card.dataset.cierre + 'T00:00:00') : null;
            var vencida = cierre && cierre < hoy;

            var data = {};
            try { data = JSON.parse(card.dataset.modal || '{}'); } catch (_) {}
            var abrirModal = function () {
              if (typeof window.openConvModal === 'function') window.openConvModal(data);
            };
            card.addEventListener('click', function (e) {
              if (e.target.closest('a') || vencida) return;
              abrirModal();
            });
            var btnDetalles = card.querySelector('.conv-ver-detalles');
            if (btnDetalles) {
              btnDetalles.addEventListener('click', function (e) {
                e.stopPropagation();
                abrirModal();
              });
            }

            if (vencida) {
              hayCerradas = true;
              card.classList.add('conv-card-vigente--vencida');

              card.querySelectorAll('.conv-vigente-badge').forEach(function (b) {
                b.classList.add('conv-vigente-badge--vencida');
                b.innerHTML = '<i class="ti ti-lock"></i> Cerrada';
              });

              if (btnDetalles) btnDetalles.hidden = true;

              var tag = document.createElement('div');
              tag.className = 'conv-card-vencida-tag';
              tag.textContent = 'CERRADA';
              card.insertBefore(tag, card.firstChild);

              cerradasGrid.appendChild(card);
            }
          });

          if (hayCerradas && cerradasSec) cerradasSec.hidden = false;
        }
      })();
      </script>

    <?php else: ?>
      <div class="admin-empty">
        <i class="ti ti-file-off"></i>
        <p>Por el momento no hay convocatorias publicadas. Vuelve a consultar pronto.</p>
      </div>
    <?php endif; ?>

    <!-- ===== REQUISITOS GENERALES ===== -->
    <div class="conv-bloque-extra">
      <div class="conv-section-title">
        <h3>Requisitos y Condiciones de Admisión</h3>
      </div>
      <div class="conv-requisitos-grid">

        <div class="conv-requisitos-card">
          <div class="conv-requisitos-card-header">
            <i class="ti ti-file-description"></i> Documentación requerida
          </div>
          <ul class="conv-requisitos-list">
            <li>
              <i class="ti ti-point-filled"></i>
              Clave Única de Registro de Población (CURP)
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              Comprobante de domicilio actual (no mayor a 3 meses)
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              Credencial Electoral (INE)
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              Título Profesional, Certificado de estudios y Cédula Profesional
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              Acta de nacimiento
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              2 cartas de recomendación (laborales o personales)
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              Currículum Vitae con fotografía
            </li>
          </ul>
        </div>

        <div class="conv-requisitos-card">
          <div class="conv-requisitos-card-header">
            <i class="ti ti-checklist"></i> Proceso de admisión
          </div>
          <ul class="conv-requisitos-list">
            <li>
              <i class="ti ti-point-filled"></i>
              Aplicación de Examen de Ubicación de Inglés
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              Acreditar Curso Propedéutico (4 materias, 8 semanas) con mínimo 8.0
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              Acreditar entrevista de admisión
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              Pago del proceso de admisión: <strong>$4,550.00</strong>
            </li>
            <li>
              <i class="ti ti-point-filled"></i>
              Costo por materia: <strong>$2,950.00</strong> (programa autofinanciable)
            </li>
          </ul>
        </div>

      </div>

      <div style="margin-top:20px;">
        <a href="../assets/docs/Procedimiento-Admision-Aspirantes.docx" target="_blank" rel="noopener" class="btn-sm-outline">
          <i class="ti ti-download"></i> Descargar el procedimiento oficial completo de Admisión
        </a>
      </div>
    </div>

    <!-- ===== CRONOGRAMA (genérico, mismos pasos institucionales cada semestre) ===== -->
    <div class="conv-bloque-cronograma">
      <div class="conv-section-title">
        <h3>Cronograma del Proceso de Admisión</h3>
      </div>
      <div id="conv-crono-grid" class="conv-cronograma-grid"></div>
      <p class="conv-cronograma-nota">
        <i class="ti ti-alert-triangle"></i>
        Las fechas están sujetas a cambios por parte de la División de Estudios de Posgrado. Consulta el documento oficial de cada convocatoria para las fechas exactas del ciclo vigente.
      </p>
    </div>

    <script>
    (function () {
      var PASOS = [
        { label:'Inscripción al proceso',                  icon:'ti-clipboard-list' },
        { label:'Inducción al proceso de admisión',        icon:'ti-presentation'  },
        { label:'Curso Propedéutico',                      icon:'ti-book'          },
        { label:'Examen de inglés',                        icon:'ti-language'      },
        { label:'Entrevistas de admisión',                 icon:'ti-users'         },
        { label:'Entrega de resultados',                   icon:'ti-mail-check'    },
        { label:'Sesión de bienvenida e inicio de clases', icon:'ti-school'        },
      ];
      var html = PASOS.map(function (paso) {
        return '<div class="conv-cronograma-item">' +
          '<div class="conv-cronograma-item-icon">' +
            '<i class="ti ' + paso.icon + '"></i>' +
          '</div>' +
          '<div><div class="conv-cronograma-item-label">' + paso.label + '</div></div>' +
        '</div>';
      }).join('');
      var cronoGrid = document.getElementById('conv-crono-grid');
      if (cronoGrid) cronoGrid.innerHTML = html;
    })();
    </script>

    <!-- Info adicional / contacto -->
    <div class="conv-contacto-aviso">
      <p>
        <strong>¿Tienes dudas sobre el proceso de admisión?</strong><br>
        Comunícate con la División de Estudios de Posgrado al
        <a href="tel:+526188271266">618 827 1266</a>
        o escríbenos a
        <a href="mailto:posgradofeca@ujed.mx">posgradofeca@ujed.mx</a>.
        Horario de atención: Lunes a Viernes 8:00 a.m. – 8:00 p.m., Sábados 9:00 a.m. – 2:00 p.m.
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
