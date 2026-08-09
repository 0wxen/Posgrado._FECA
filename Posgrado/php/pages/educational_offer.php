<?php
require_once __DIR__ . '/../includes/content.php';
$programas = listar_programas();

const NIVEL_CLASE = ['doctorado' => 'level-doc', 'especialidad' => 'level-esp', 'maestria' => ''];
const NIVEL_ETIQUETA = ['doctorado' => 'Doctorado', 'especialidad' => 'Especialidad', 'maestria' => 'Maestría'];
const MODALIDAD_ICONO = ['presencial' => 'ti-building', 'virtual' => 'ti-device-laptop', 'mixta' => 'ti-building-community'];
const MODALIDAD_ETIQUETA = ['presencial' => 'Presencial', 'virtual' => 'Virtual', 'mixta' => 'Mixta'];
?>
<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Oferta Educativa</h1>
    <p class="page-banner-desc">
      Conoce nuestros programas de posgrado y encuentra la opción que mejor
      se alinee con tus metas académicas y profesionales.
    </p>
  </div>
</section>

<!-- ===== PROGRAMAS ===== -->
<section class="seccion seccion-gris">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker"><?= !empty($programas) ? count($programas) : 8 ?> programas disponibles</span>
      <h2>Programas de Posgrado</h2>
      <p>
        Todos nuestros programas cuentan con planta docente de alto nivel y
        están orientados al impacto regional y nacional.
      </p>
    </div>

    <!-- Pestañas de filtrado -->
    <div class="comunidad-tab-header" id="oferta-tabs" style="margin-bottom:32px;">
      <button class="comunidad-tab-title activo" data-filtro="todos">
        <i class="ti ti-layout-grid"></i> Todos
      </button>
      <button class="comunidad-tab-title" data-filtro="maestria">
        <i class="ti ti-school"></i> Maestrías
      </button>
      <button class="comunidad-tab-title" data-filtro="doctorado">
        <i class="ti ti-award"></i> Doctorado
      </button>
      <button class="comunidad-tab-title" data-filtro="especialidad">
        <i class="ti ti-stethoscope"></i> Especialidad
      </button>
      <button class="comunidad-tab-title" data-filtro="hibrida">
        <i class="ti ti-device-laptop"></i> Estudia de Forma Híbrida
      </button>
    </div>

    <div class="programs-grid" id="programs-grid">

      <?php if (!empty($programas)): ?>
        <?php foreach ($programas as $p): $slugPrograma = 'program_' . strtolower($p['codigo']); ?>
          <div class="program-card" data-nivel="<?= h($p['nivel']) ?>" data-page="<?= h($slugPrograma) ?>" style="cursor:pointer;">
            <div class="program-card-hdr">
              <span class="program-level <?= h(NIVEL_CLASE[$p['nivel']] ?? '') ?>"><?= h(NIVEL_ETIQUETA[$p['nivel']] ?? $p['nivel']) ?></span>
              <span class="program-sigla"><?= h($p['codigo']) ?></span>
            </div>
            <div class="program-card-body">
              <h3><?= h($p['nombre']) ?></h3>
              <?php if (!empty($p['descripcion'])): ?>
                <p><?= h(mb_strimwidth($p['descripcion'], 0, 160, '…')) ?></p>
              <?php endif; ?>
              <div class="program-tags">
                <?php if (!empty($p['duracion_semestres'])): ?>
                  <span class="program-tag"><i class="ti ti-clock"></i> <?= (int) $p['duracion_semestres'] ?> semestres</span>
                <?php endif; ?>
                <?php if (!empty($p['modalidad'])): ?>
                  <span class="program-tag"><i class="ti <?= h(MODALIDAD_ICONO[$p['modalidad']] ?? 'ti-building') ?>"></i> <?= h(MODALIDAD_ETIQUETA[$p['modalidad']] ?? $p['modalidad']) ?></span>
                <?php endif; ?>
              </div>
              <div class="program-card-actions">
                <a href="#<?= h($slugPrograma) ?>" class="btn-sm-rojo" data-page="<?= h($slugPrograma) ?>"><i class="ti ti-info-circle"></i> Más info</a>
                <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Convocatoria</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      <?php else: ?>

      <!-- DGO -->
      <div class="program-card" data-nivel="doctorado" data-page="program_dgo" style="cursor:pointer;">
        <div class="program-card-hdr">
          <span class="program-level level-doc">Doctorado</span>
          <span class="program-sigla">DGO</span>
        </div>
        <div class="program-card-body">
          <h3>Doctorado en Gestión de las Organizaciones</h3>
          <p>
            Forma investigadores y académicos con capacidad para generar
            conocimiento científico aplicado a la gestión organizacional en
            contextos complejos y globalizados.
          </p>
          <div class="program-tags">
            <span class="program-tag"><i class="ti ti-clock"></i> 4 años</span>
            <span class="program-tag"><i class="ti ti-building-university"></i> Presencial</span>
          </div>
          <div class="program-card-actions">
            <a href="#program_dgo" class="btn-sm-rojo" data-page="program_dgo"><i class="ti ti-info-circle"></i> Más info</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Convocatoria</a>
          </div>
        </div>
      </div>

      <!-- EAH -->
      <div class="program-card" data-nivel="especialidad" data-page="program_eah" style="cursor:pointer;">
        <div class="program-card-hdr">
          <span class="program-level level-esp">Especialidad</span>
          <span class="program-sigla">EAH</span>
        </div>
        <div class="program-card-body">
          <h3>Especialidad en Administración de Hospitales</h3>
          <p>
            Desarrolla habilidades de gestión en el sector salud para
            optimizar los recursos y mejorar la calidad en la atención
            de unidades hospitalarias.
          </p>
          <div class="program-tags">
            <span class="program-tag"><i class="ti ti-clock"></i> 1 año</span>
            <span class="program-tag"><i class="ti ti-building-hospital"></i> Presencial</span>
          </div>
          <div class="program-card-actions">
            <a href="#program_eah" class="btn-sm-rojo" data-page="program_eah"><i class="ti ti-info-circle"></i> Más info</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Convocatoria</a>
          </div>
        </div>
      </div>

      <!-- MAG -->
      <div class="program-card" data-nivel="maestria" data-page="program_mag" style="cursor:pointer;">
        <div class="program-card-hdr">
          <span class="program-level">Maestría</span>
          <span class="program-sigla">MAG</span>
        </div>
        <div class="program-card-body">
          <h3>Maestría en Auditoría Gubernamental</h3>
          <p>
            Capacita profesionales para ejercer la auditoría en organismos
            públicos con un enfoque de transparencia, legalidad y eficiencia
            en el uso de recursos gubernamentales.
          </p>
          <div class="program-tags">
            <span class="program-tag"><i class="ti ti-clock"></i> 2 años</span>
            <span class="program-tag"><i class="ti ti-building-community"></i> Presencial</span>
          </div>
          <div class="program-card-actions">
            <a href="#program_mag" class="btn-sm-rojo" data-page="program_mag"><i class="ti ti-info-circle"></i> Más info</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Convocatoria</a>
          </div>
        </div>
      </div>

      <!-- ME -->
      <div class="program-card" data-nivel="maestria" data-page="program_me" style="cursor:pointer;">
        <div class="program-card-hdr">
          <span class="program-level">Maestría</span>
          <span class="program-pnpc"><i class="ti ti-star"></i> SNP · CONAHCYT</span>
          <span class="program-sigla">ME</span>
        </div>
        <div class="program-card-body">
          <h3>Maestría en Economía</h3>
          <p>
            Desarrolla competencias analíticas avanzadas para comprender
            y resolver los desafíos económicos locales, regionales y
            globales mediante la investigación aplicada.
          </p>
          <div class="program-tags">
            <span class="program-tag"><i class="ti ti-clock"></i> 2 años</span>
            <span class="program-tag"><i class="ti ti-chart-line"></i> Presencial</span>
          </div>
          <div class="program-card-actions">
            <a href="#program_me" class="btn-sm-rojo" data-page="program_me"><i class="ti ti-info-circle"></i> Más info</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Convocatoria</a>
          </div>
        </div>
      </div>

      <!-- MEC -->
      <div class="program-card" data-nivel="maestria" data-page="program_mec" style="cursor:pointer;">
        <div class="program-card-hdr">
          <span class="program-level">Maestría</span>
          <span class="program-sigla">MEC</span>
        </div>
        <div class="program-card-body">
          <h3>Maestría en Estrategias Contables</h3>
          <p>
            Especialízate en análisis financiero, planeación fiscal y
            estrategias contables para la toma de decisiones efectiva
            en organizaciones públicas y privadas.
          </p>
          <div class="program-tags">
            <span class="program-tag"><i class="ti ti-clock"></i> 2 años</span>
            <span class="program-tag"><i class="ti ti-receipt"></i> Presencial</span>
          </div>
          <div class="program-card-actions">
            <a href="#program_mec" class="btn-sm-rojo" data-page="program_mec"><i class="ti ti-info-circle"></i> Más info</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Convocatoria</a>
          </div>
        </div>
      </div>

      <!-- MGN -->
      <div class="program-card" data-nivel="maestria" data-page="program_mgn" style="cursor:pointer;">
        <div class="program-card-hdr">
          <span class="program-level">Maestría</span>
          <span class="program-sigla">MGN</span>
        </div>
        <div class="program-card-body">
          <h3>Maestría en Gestión de Negocios</h3>
          <p>
            Forma competencias estratégicas para liderar y transformar
            organizaciones en entornos dinámicos, globales y altamente
            competitivos con visión empresarial.
          </p>
          <div class="program-tags">
            <span class="program-tag"><i class="ti ti-clock"></i> 2 años</span>
            <span class="program-tag"><i class="ti ti-briefcase"></i> Presencial</span>
          </div>
          <div class="program-card-actions">
            <a href="#program_mgn" class="btn-sm-rojo" data-page="program_mgn"><i class="ti ti-info-circle"></i> Más info</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Convocatoria</a>
          </div>
        </div>
      </div>

      <!-- MGP -->
      <div class="program-card" data-nivel="maestria" data-page="program_mgp" style="cursor:pointer;">
        <div class="program-card-hdr">
          <span class="program-level">Maestría</span>
          <span class="program-sigla">MGP</span>
        </div>
        <div class="program-card-body">
          <h3>Maestría en Gestión Pública</h3>
          <p>
            Prepara servidores públicos y gestores con capacidad de
            análisis, diseño e implementación de políticas para impulsar
            la modernización y el desarrollo institucional.
          </p>
          <div class="program-tags">
            <span class="program-tag"><i class="ti ti-clock"></i> 2 años</span>
            <span class="program-tag"><i class="ti ti-building"></i> Presencial</span>
          </div>
          <div class="program-card-actions">
            <a href="#program_mgp" class="btn-sm-rojo" data-page="program_mgp"><i class="ti ti-info-circle"></i> Más info</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Convocatoria</a>
          </div>
        </div>
      </div>

      <!-- MM -->
      <div class="program-card" data-nivel="maestria" data-page="program_mm" style="cursor:pointer;">
        <div class="program-card-hdr">
          <span class="program-level">Maestría</span>
          <span class="program-sigla">MM</span>
        </div>
        <div class="program-card-body">
          <h3>Maestría en Mercadotecnia</h3>
          <p>
            Desarrolla habilidades para diseñar, ejecutar y evaluar
            estrategias de marketing en entornos digitales y tradicionales,
            orientadas al posicionamiento y creación de valor.
          </p>
          <div class="program-tags">
            <span class="program-tag"><i class="ti ti-clock"></i> 2 años</span>
            <span class="program-tag"><i class="ti ti-speakerphone"></i> Presencial</span>
          </div>
          <div class="program-card-actions">
            <a href="#program_mm" class="btn-sm-rojo" data-page="program_mm"><i class="ti ti-info-circle"></i> Más info</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Convocatoria</a>
          </div>
        </div>
      </div>

      <?php endif; ?>

    </div>

    <div class="seccion-cta" id="oferta-cta-normal">
      <a href="#convocatorias" class="btn-link-rojo" data-page="convocatorias">
        Ver convocatorias abiertas <i class="ti ti-arrow-right"></i>
      </a>
    </div>

    <div id="oferta-hibrida" style="display:none;">
      <div class="directorio-grid" style="margin-bottom:32px;">
        <div class="directorio-item">
          <div class="directorio-icon"><i class="ti ti-building-community"></i></div>
          <div>
            <div class="directorio-nombre">Sesiones Presenciales</div>
            <div class="directorio-cargo">Información próximamente disponible.</div>
          </div>
        </div>
        <div class="directorio-item">
          <div class="directorio-icon"><i class="ti ti-device-laptop"></i></div>
          <div>
            <div class="directorio-nombre">Sesiones Virtuales</div>
            <div class="directorio-cargo">Información próximamente disponible.</div>
          </div>
        </div>
        <div class="directorio-item">
          <div class="directorio-icon"><i class="ti ti-calendar-event"></i></div>
          <div>
            <div class="directorio-nombre">Calendario y Horarios</div>
            <div class="directorio-cargo">Información próximamente disponible.</div>
          </div>
        </div>
        <div class="directorio-item">
          <div class="directorio-icon"><i class="ti ti-wifi"></i></div>
          <div>
            <div class="directorio-nombre">Plataforma Digital</div>
            <div class="directorio-cargo">Información próximamente disponible.</div>
          </div>
        </div>
      </div>
      <p style="font-size:11px;color:#aaa;line-height:1.7;border-top:1px solid #eee;padding-top:14px;">* La modalidad híbrida combina sesiones presenciales y virtuales, alternando según la naturaleza de cada asignatura y el avance del grupo. Esto permite mantener la cercanía académica del aula cuando el contenido lo requiere, y aprovechar la flexibilidad de lo virtual cuando el proceso de aprendizaje así lo permite. De esta manera, se optimiza el tiempo del estudiante sin comprometer la calidad de la formación.</p>
    </div>
  </div>
</section>

<script>
(function () {
  var tabs    = document.querySelectorAll('#oferta-tabs [data-filtro]');
  var cards   = document.querySelectorAll('#programs-grid [data-nivel]');
  var grid    = document.getElementById('programs-grid');
  var hibrida = document.getElementById('oferta-hibrida');
  var ctaNorm = document.getElementById('oferta-cta-normal');
  if (!tabs.length) return;

  tabs.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var filtro = btn.dataset.filtro;

      tabs.forEach(function (b) { b.classList.remove('activo'); });
      btn.classList.add('activo');

      if (filtro === 'hibrida') {
        if (grid)    grid.style.display    = 'none';
        if (ctaNorm) ctaNorm.style.display = 'none';
        if (hibrida) hibrida.style.display = '';
      } else {
        if (grid)    grid.style.display    = '';
        if (ctaNorm) ctaNorm.style.display = '';
        if (hibrida) hibrida.style.display = 'none';

        cards.forEach(function (card) {
          var visible = filtro === 'todos' || card.dataset.nivel === filtro;
          card.style.display = visible ? '' : 'none';
        });
      }
    });
  });
})();
</script>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#nosotros" class="pnb-prev" data-page="nosotros">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Anterior</span>
        <span class="pnb-name">Nosotros</span>
      </span>
    </a>
    <a href="#inicio" class="pnb-home" data-page="inicio" title="Volver a Inicio">
      <i class="ti ti-home"></i>
    </a>
    <a href="#investigacion" class="pnb-next" data-page="investigacion">
      <span class="pnb-info">
        <span class="pnb-dir">Siguiente</span>
        <span class="pnb-name">Investigación</span>
      </span>
      <span class="pnb-arrow"><i class="ti ti-arrow-right"></i></span>
    </a>
  </div>
</nav>
