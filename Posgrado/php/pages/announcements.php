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

    <div class="conv-section-title" style="margin-bottom:28px;">
      <h3>Convocatorias Abiertas</h3>
      <span class="conv-vigente-badge">
        <i class="ti ti-circle-filled" style="font-size:8px;"></i>
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
            $modalJson = h(json_encode($modalData, JSON_UNESCAPED_UNICODE));
          ?>
          <div class="conv-card-vigente" style="cursor:pointer;" data-cierre="<?= h($item['fecha_cierre'] ?? '') ?>" data-modal="<?= $modalJson ?>">
            <div class="conv-card-vigente-body">
              <span class="conv-vigente-badge" style="font-size:10px;"><i class="ti ti-circle-filled" style="font-size:7px;"></i> <?= h($item['ciclo'] ?? '') ?></span>
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
                  <i class="ti ti-download"></i> Descargar
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- ===== CONVOCATORIAS CERRADAS (auto-visible al vencer) ===== -->
      <div id="conv-cerradas-section" hidden style="margin-top:44px;">
        <div class="conv-section-title" style="margin-bottom:20px;">
          <h3 style="color:#777;">Convocatorias Cerradas</h3>
          <span style="background:#eee;color:#888;padding:3px 12px;border-radius:99px;font-size:11px;font-weight:700;letter-spacing:.07em;display:inline-flex;align-items:center;gap:5px;">
            <i class="ti ti-lock" style="font-size:10px;"></i> Proceso finalizado
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
              card.style.opacity = '0.6';
              card.style.cursor  = 'default';

              card.querySelectorAll('.conv-vigente-badge').forEach(function (b) {
                b.style.background  = '#aaa';
                b.style.color       = '#fff';
                b.style.borderColor = '#aaa';
                b.innerHTML = '<i class="ti ti-lock" style="font-size:7px;"></i> Cerrada';
              });

              if (btnDetalles) btnDetalles.style.display = 'none';

              var tag = document.createElement('div');
              tag.style.cssText = 'position:absolute;top:10px;right:10px;background:#888;color:#fff;font-size:9px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;padding:3px 9px;border-radius:3px;pointer-events:none;';
              tag.textContent = 'CERRADA';
              card.style.position = 'relative';
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
    <div style="margin-top:44px;">
      <div class="conv-section-title" style="margin-bottom:20px;">
        <h3>Requisitos y Condiciones de Admisión</h3>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        <div style="background:#fff; border:1px solid rgba(0,0,0,0.07); border-radius:6px; padding:24px;">
          <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:var(--dorado);margin-bottom:14px;">
            <i class="ti ti-file-description" style="font-size:14px;"></i> Documentación requerida
          </div>
          <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:9px;">
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Clave Única de Registro de Población (CURP)
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Comprobante de domicilio actual (no mayor a 3 meses)
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Credencial Electoral (INE)
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Título Profesional, Certificado de estudios y Cédula Profesional
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Acta de nacimiento
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              2 cartas de recomendación (laborales o personales)
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Currículum Vitae con fotografía
            </li>
          </ul>
        </div>

        <div style="background:#fff; border:1px solid rgba(0,0,0,0.07); border-radius:6px; padding:24px;">
          <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:var(--dorado);margin-bottom:14px;">
            <i class="ti ti-checklist" style="font-size:14px;"></i> Proceso de admisión
          </div>
          <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:9px;">
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Aplicación de Examen de Ubicación de Inglés
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Acreditar Curso Propedéutico (4 materias, 8 semanas) con mínimo 8.0
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Acreditar entrevista de admisión
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Pago del proceso de admisión: <strong>$4,550.00</strong>
            </li>
            <li style="font-size:13px;color:#555;display:flex;align-items:flex-start;gap:8px;line-height:1.5;">
              <i class="ti ti-point-filled" style="color:var(--rojo);font-size:10px;margin-top:4px;flex-shrink:0;"></i>
              Costo por materia: <strong>$2,950.00</strong> (programa autofinanciable)
            </li>
          </ul>
        </div>

      </div>
    </div>

    <!-- ===== CRONOGRAMA (genérico, mismos pasos institucionales cada semestre) ===== -->
    <div style="margin-top:44px; margin-bottom:16px;">
      <div class="conv-section-title" style="margin-bottom:20px;">
        <h3>Cronograma del Proceso de Admisión</h3>
      </div>
      <div id="conv-crono-grid" style="display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:14px;"></div>
      <p style="font-size:12px;color:#aaa;margin-top:14px;font-style:italic;">
        <i class="ti ti-alert-triangle" style="font-size:13px;color:var(--dorado);"></i>
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
        return '<div style="background:#fff;border:1px solid #eee;border-left:3px solid var(--dorado);border-radius:4px;padding:14px 16px;display:flex;gap:12px;align-items:flex-start;">' +
          '<div style="width:36px;height:36px;background:rgba(168,127,61,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">' +
            '<i class="ti ' + paso.icon + '" style="color:var(--dorado);font-size:18px;"></i>' +
          '</div>' +
          '<div><div style="font-size:14px;font-weight:700;color:#333;">' + paso.label + '</div></div>' +
        '</div>';
      }).join('');
      var cronoGrid = document.getElementById('conv-crono-grid');
      if (cronoGrid) cronoGrid.innerHTML = html;
    })();
    </script>

    <!-- Info adicional / contacto -->
    <div style="margin-top:40px; padding:20px 24px; background:#f8f7f5; border-left:4px solid var(--rojo-oscuro); border-radius:0 6px 6px 0;">
      <p style="font-size:14px; color:#555; line-height:1.7; margin:0;">
        <strong>¿Tienes dudas sobre el proceso de admisión?</strong><br>
        Comunícate con la División de Estudios de Posgrado al
        <a href="tel:+526188271266" style="color:var(--rojo);font-weight:700;">618 827 1266</a>
        o escríbenos a
        <a href="mailto:posgradofeca@ujed.mx" style="color:var(--rojo);font-weight:700;">posgradofeca@ujed.mx</a>.
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
