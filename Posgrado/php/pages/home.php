<?php
require_once __DIR__ . '/../includes/content.php';
$noticias         = listar_blog(3);
$convocatorias_db = array_slice(listar_convocatorias(true), 0, 5);
$imagenes_sitio   = listar_imagenes_sitio();
$mensajes_institucionales = listar_mensajes_institucionales();

// Años de trayectoria: se calculan a partir del año de fundación.
// AÚN NO SE TIENE LA FECHA EXACTA -- estas dos constantes son placeholders
// (hoy dan 7 y 10 años) hasta que la División confirme los años reales.
const ANIO_FUNDACION_FECA     = 2019; // "la escuela" -- ajustar cuando se tenga el dato real
const ANIO_FUNDACION_POSGRADO = 2016; // "el otro" (la División de Posgrado) -- ajustar cuando se tenga el dato real
$anios_feca     = (int) date('Y') - ANIO_FUNDACION_FECA;
$anios_posgrado = (int) date('Y') - ANIO_FUNDACION_POSGRADO;
?>

<!-- ===== HERO (v6) — dos columnas: texto institucional + imagen contenida ===== -->
<section class="hero-split" id="hero-inicio">
  <div class="hero-split-inner">

    <div class="hero-split-content">
      <span class="hero-split-kicker">División de Estudios de Posgrado · FECA · UJED</span>
      <h1 class="hero-split-title">La herramienta para el futuro<br>que tú deseas</h1>
      <p class="hero-split-desc">
        Formamos líderes con excelencia académica, investigación y compromiso
        para el desarrollo de la sociedad.
      </p>
      <div class="hero-split-actions">
        <a href="#convocatorias" class="btn-primary" data-page="convocatorias">
          <i class="ti ti-file-text"></i> Ver Convocatorias
        </a>
        <a href="#nosotros" class="btn-outline-white" data-page="nosotros">
          Conoce más
        </a>
      </div>
      <div class="hero-split-stats">
        <div class="hero-split-stat">
          <div class="hero-split-stat-num">5+</div>
          <div class="hero-split-stat-label">Programas de Posgrado</div>
        </div>
        <div class="hero-split-stat">
          <div class="hero-split-stat-num"><?= $anios_posgrado ?>+</div>
          <div class="hero-split-stat-label">Años de Trayectoria</div>
        </div>
        <div class="hero-split-stat">
          <div class="hero-split-stat-num"><?= $anios_feca ?>+</div>
          <div class="hero-split-stat-label">Años de la FECA</div>
        </div>
        <div class="hero-split-stat">
          <div class="hero-split-stat-num">SNP</div>
          <div class="hero-split-stat-label">Reconocimiento Nacional</div>
        </div>
      </div>
    </div>

    <?php
      // El banner debe mostrar las MISMAS convocatorias que la sección de abajo, no otro contenido.
      $hero_acentos = [
        ['#b71c1c', '#7f0000'],
        ['#a87f3d', '#6d5227'],
        ['#1a3a5c', '#0d2035'],
      ];
      $hero_iconos = ['ti-chart-line', 'ti-briefcase', 'ti-building-community', 'ti-calculator', 'ti-heartbeat'];
      if (!empty($convocatorias_db)) {
        $hero_slides = $convocatorias_db;
      } else {
        // Cartel y PDFs reales (bajados del sitio oficial, que hoy tiene el
        // certificado SSL vencido -- se hospedan aquí en vez de depender de
        // ese dominio roto). $hero_conv['imagen_url']/['archivo_url'] pasan
        // por url_subida(), que ya antepone "../php/" -- por eso aquí solo
        // se pone el "../" que cancela ese "php/" y deja la ruta en assets/.
        $CONV_BANNER_A2025 = '../assets/img/convocatoria-abierta-a2025.png';
        $hero_slides = [
          ['titulo' => 'Maestría en Gestión Pública', 'ciclo' => 'A-2025', 'programa' => 'program_mgp',
           'descripcion' => 'Prepara servidores públicos capaces de impulsar el desarrollo y la modernización institucional.',
           'imagen_url' => $CONV_BANNER_A2025,
           'archivo_url' => '../assets/docs/Convocatoria%20MGP-A2025.pdf'],
          ['titulo' => 'Maestría en Estrategias Contables', 'ciclo' => 'A-2025', 'programa' => 'program_mec',
           'descripcion' => 'Especialízate en análisis financiero y planeación fiscal para una toma de decisiones efectiva.',
           'imagen_url' => $CONV_BANNER_A2025,
           'archivo_url' => '../assets/docs/Convocatoria%20MEC-A2025.pdf'],
          ['titulo' => 'Especialidad en Administración de Hospitales', 'ciclo' => 'A-2025', 'programa' => 'program_eah',
           'descripcion' => 'Desarrolla habilidades de gestión en salud para mejorar la calidad de la atención hospitalaria.',
           'imagen_url' => $CONV_BANNER_A2025,
           'archivo_url' => '../assets/docs/Convocatoria%20EAH-A2025.pdf'],
        ];
      }
    ?>
    <div class="hero-split-visual" id="hero-split-visual">

      <?php foreach ($hero_slides as $indice_slide => $hero_conv): ?>
        <?php
          $par = $hero_acentos[$indice_slide % count($hero_acentos)];
          $icono = $hero_iconos[$indice_slide % count($hero_iconos)];
        ?>
        <div class="hero-split-slide<?= $indice_slide === 0 ? ' activo' : '' ?>"
             data-conv-title="<?= h($hero_conv['titulo']) ?>"
             data-conv-img="<?= h(url_subida($hero_conv['imagen_url'] ?? null)) ?>"
             data-conv-badge="Convocatoria Abierta"
             data-conv-ciclo="<?= h($hero_conv['ciclo'] ?? '') ?>"
             data-conv-limite="<?= !empty($hero_conv['fecha_cierre']) ? 'Límite: ' . h($hero_conv['fecha_cierre']) : '' ?>"
             data-conv-desc="<?= h($hero_conv['descripcion'] ?? '') ?>"
             data-conv-requisitos="<?= h($hero_conv['requisitos'] ?? '') ?>"
             data-conv-programa="<?= h($hero_conv['programa'] ?? '') ?>"
             data-conv-doc="<?= h(url_subida($hero_conv['archivo_url'] ?? null)) ?>">
          <div class="hero-split-media" style="--tint1:<?= h($par[0]) ?>; --tint2:<?= h($par[1]) ?>">
            <i class="ti <?= h($icono) ?>"></i>
          </div>
          <div class="hero-split-caption">
            <span class="hero-split-caption-kicker">Convocatoria Abierta</span>
            <span class="hero-split-caption-title"><?= h($hero_conv['titulo']) ?></span>
          </div>
        </div>
      <?php endforeach; ?>

      <button class="hero-split-nav hero-split-nav-prev" aria-label="Convocatoria anterior">
        <i class="ti ti-chevron-left"></i>
      </button>
      <button class="hero-split-nav hero-split-nav-next" aria-label="Siguiente convocatoria">
        <i class="ti ti-chevron-right"></i>
      </button>

      <div class="hero-split-dots">
        <?php foreach ($hero_slides as $indice_slide => $hero_conv): ?>
          <button class="hero-split-dot<?= $indice_slide === 0 ? ' activo' : '' ?>"
                  data-goto="<?= $indice_slide ?>"
                  aria-label="Ver <?= h($hero_conv['titulo']) ?>"></button>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</section>

<script>
(function () {
  var visual = document.getElementById('hero-split-visual');
  if (!visual) return;
  var slides  = visual.querySelectorAll('.hero-split-slide');
  var dots    = visual.querySelectorAll('.hero-split-dot');
  var btnPrev = visual.querySelector('.hero-split-nav-prev');
  var btnNext = visual.querySelector('.hero-split-nav-next');
  if (!slides.length) return;
  var current = 0;
  var timer;
  var DURACION = 4500;

  function render() {
    slides.forEach(function (s, i) { s.classList.toggle('activo', i === current); });
    dots.forEach(function (d, i) { d.classList.toggle('activo', i === current); });
  }
  function goTo(idx) {
    current = (idx + slides.length) % slides.length;
    render();
  }
  function resetTimer() {
    clearInterval(timer);
    timer = setInterval(function () { goTo(current + 1); }, DURACION);
  }

  if (btnPrev) btnPrev.addEventListener('click', function (e) { e.stopPropagation(); goTo(current - 1); resetTimer(); });
  if (btnNext) btnNext.addEventListener('click', function (e) { e.stopPropagation(); goTo(current + 1); resetTimer(); });
  dots.forEach(function (d, i) {
    d.addEventListener('click', function (e) { e.stopPropagation(); goTo(i); resetTimer(); });
  });
  slides.forEach(function (s) {
    s.addEventListener('click', function () {
      if (typeof window.openConvModal !== 'function') return;
      window.openConvModal({
        img:      s.dataset.convImg,
        badge:    s.dataset.convBadge,
        title:    s.dataset.convTitle,
        ciclo:    s.dataset.convCiclo,
        limite:   s.dataset.convLimite,
        desc:     s.dataset.convDesc,
        requisitos: s.dataset.convRequisitos,
        programa: s.dataset.convPrograma,
        doc:      s.dataset.convDoc
      });
    });
  });

  render();
  resetTimer();

  document.querySelectorAll('.conv-grid .conv-card[data-conv-title]').forEach(function (card) {
    card.addEventListener('click', function (e) {
      if (e.target.closest('a')) return; // deja que "Descargar"/"Más Información" funcionen normal
      if (typeof window.openConvModal !== 'function') return;
      window.openConvModal({
        img:        card.dataset.convImg,
        badge:      card.dataset.convBadge,
        title:      card.dataset.convTitle,
        ciclo:      card.dataset.convCiclo,
        limite:     card.dataset.convLimite,
        desc:       card.dataset.convDesc,
        requisitos: card.dataset.convRequisitos,
        programa:   card.dataset.convPrograma,
        doc:        card.dataset.convDoc
      });
    });
  });
})();
</script>


<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Activas ahora</span>
      <h2>Convocatorias Abiertas</h2>
      <p>Consulta los programas con admisión abierta e inscríbete para el próximo ciclo escolar.</p>
    </div>

    <div class="conv-grid">
      <?php if (!empty($convocatorias_db)): ?>

        <?php foreach ($convocatorias_db as $conv): ?>
          <div class="conv-card" style="cursor:pointer;"
               data-conv-title="<?= h($conv['titulo']) ?>"
               data-conv-img="<?= h(url_subida($conv['imagen_url'] ?? null)) ?>"
               data-conv-badge="Convocatoria Abierta"
               data-conv-ciclo="<?= h($conv['ciclo'] ?? '') ?>"
               data-conv-limite="<?= !empty($conv['fecha_cierre']) ? 'Límite: ' . h($conv['fecha_cierre']) : '' ?>"
               data-conv-desc="<?= h($conv['descripcion'] ?? '') ?>"
               data-conv-requisitos="<?= h($conv['requisitos'] ?? '') ?>"
               data-conv-doc="<?= h(url_subida($conv['archivo_url'] ?? null)) ?>">
            <?php if (!empty($conv['imagen_url'])): ?>
              <img src="<?= h(url_subida($conv['imagen_url'])) ?>"
                   class="conv-card-poster" alt="<?= h($conv['titulo']) ?>">
            <?php endif; ?>
            <span class="conv-badge">Convocatoria Abierta<?= !empty($conv['ciclo']) ? ' · ' . h($conv['ciclo']) : '' ?></span>
            <h3><?= h($conv['titulo']) ?></h3>
            <?php if (!empty($conv['descripcion'])): ?>
              <p><?= h($conv['descripcion']) ?></p>
            <?php endif; ?>
            <div class="conv-card-actions">
              <?php if (!empty($conv['archivo_url'])): ?>
                <a href="<?= h(url_subida($conv['archivo_url'])) ?>"
                   target="_blank" rel="noopener" class="btn-sm-rojo">
                  <i class="ti ti-download"></i> Descargar Convocatoria
                </a>
              <?php endif; ?>
              <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">
                Más Información
              </a>
            </div>
          </div>
        <?php endforeach; ?>

      <?php else: ?>

        <?php
          // Cartel y PDFs reales, bajados del sitio oficial (que hoy tiene el
          // certificado SSL vencido) y hospedados localmente para que sí carguen.
          $conv_banner_a2025 = '../assets/img/convocatoria-abierta-a2025.png';
          $conv_pdf_base = '../assets/docs/Convocatoria%20';
        ?>
        <div class="conv-card" style="cursor:pointer;"
             data-conv-title="Maestría en Gestión Pública"
             data-conv-badge="Convocatoria Abierta"
             data-conv-ciclo="A-2025"
             data-conv-desc="Prepara servidores públicos capaces de impulsar el desarrollo y la modernización institucional."
             data-conv-img="<?= h($conv_banner_a2025) ?>"
             data-conv-doc="<?= h($conv_pdf_base . 'MGP-A2025.pdf') ?>"
             data-conv-programa="program_mgp">
          <span class="conv-badge">Ciclo A-2025</span>
          <h3>Maestría en Gestión Pública</h3>
          <p>Prepara servidores públicos capaces de impulsar el desarrollo y la modernización institucional.</p>
          <div class="conv-card-actions">
            <a href="<?= h($conv_pdf_base . 'MGP-A2025.pdf') ?>" target="_blank" rel="noopener" class="btn-sm-rojo"><i class="ti ti-download"></i> Descargar Convocatoria</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Más Información</a>
          </div>
        </div>

        <div class="conv-card" style="cursor:pointer;"
             data-conv-title="Maestría en Estrategias Contables"
             data-conv-badge="Convocatoria Abierta"
             data-conv-ciclo="A-2025"
             data-conv-desc="Especialízate en análisis financiero y planeación fiscal para una toma de decisiones efectiva."
             data-conv-img="<?= h($conv_banner_a2025) ?>"
             data-conv-doc="<?= h($conv_pdf_base . 'MEC-A2025.pdf') ?>"
             data-conv-programa="program_mec">
          <span class="conv-badge">Ciclo A-2025</span>
          <h3>Maestría en Estrategias Contables</h3>
          <p>Especialízate en análisis financiero y planeación fiscal para una toma de decisiones efectiva.</p>
          <div class="conv-card-actions">
            <a href="<?= h($conv_pdf_base . 'MEC-A2025.pdf') ?>" target="_blank" rel="noopener" class="btn-sm-rojo"><i class="ti ti-download"></i> Descargar Convocatoria</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Más Información</a>
          </div>
        </div>

        <div class="conv-card" style="cursor:pointer;"
             data-conv-title="Especialidad en Administración de Hospitales"
             data-conv-badge="Convocatoria Abierta"
             data-conv-ciclo="A-2025"
             data-conv-desc="Desarrolla habilidades de gestión en salud para mejorar la calidad de la atención hospitalaria."
             data-conv-img="<?= h($conv_banner_a2025) ?>"
             data-conv-doc="<?= h($conv_pdf_base . 'EAH-A2025.pdf') ?>"
             data-conv-programa="program_eah">
          <span class="conv-badge">Ciclo A-2025</span>
          <h3>Especialidad en Administración de Hospitales</h3>
          <p>Desarrolla habilidades de gestión en salud para mejorar la calidad de la atención hospitalaria.</p>
          <div class="conv-card-actions">
            <a href="<?= h($conv_pdf_base . 'EAH-A2025.pdf') ?>" target="_blank" rel="noopener" class="btn-sm-rojo"><i class="ti ti-download"></i> Descargar Convocatoria</a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Más Información</a>
          </div>
        </div>

      <?php endif; ?>
    </div>

    <div class="seccion-cta">
      <a href="#convocatorias" class="btn-link-rojo" data-page="convocatorias">
        Ver todas las convocatorias <i class="ti ti-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- ===== NOTICIAS ===== -->
<section class="seccion seccion-gris">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Últimas actualizaciones</span>
      <h2>Nuestras Noticias</h2>
    </div>

    <div class="noticias-grid">
      <?php if (!empty($noticias)): ?>

        <?php foreach ($noticias as $noticia): ?>
          <article class="noticia-card">
            <div class="noticia-img">
              <?php if (!empty($noticia['imagen_url'])): ?>
                <img src="<?= h(url_subida($noticia['imagen_url'])) ?>"
                     alt="<?= h($noticia['titulo']) ?>">
              <?php else: ?>
                <i class="ti ti-news"></i>
                <span>Imagen de noticia</span>
              <?php endif; ?>
            </div>
            <div class="noticia-body">
              <span class="noticia-tag">Noticia</span>
              <h3><?= h($noticia['titulo']) ?></h3>
              <?php if (!empty($noticia['resumen'])): ?>
                <p><?= h(mb_strimwidth($noticia['resumen'], 0, 110, '…')) ?></p>
              <?php endif; ?>
              <a href="#blog" class="noticia-leer" data-page="blog">
                Leer más <i class="ti ti-arrow-right"></i>
              </a>
            </div>
          </article>
        <?php endforeach; ?>

      <?php else: ?>
        <div class="admin-empty">
          <i class="ti ti-news-off"></i>
          <p>Por el momento no hay noticias publicadas. Vuelve a consultar pronto.</p>
        </div>
      <?php endif; ?>
    </div>

    <div class="seccion-cta">
      <a href="#blog" class="btn-link-rojo" data-page="blog">
        Ver todas las noticias <i class="ti ti-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- ===== NOSOTROS ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Quiénes somos</span>
      <h2>Nosotros</h2>
    </div>

    <div class="directivos-grid">
      <?php if (!empty($mensajes_institucionales)): ?>
        <?php foreach ($mensajes_institucionales as $msg): ?>
          <div class="directivo-card">
            <div class="directivo-foto">
              <?php if (!empty($msg['foto_url'])): ?>
                <img src="<?= h(url_subida($msg['foto_url'])) ?>" alt="<?= h($msg['nombre']) ?>" style="width:100%;height:100%;object-fit:cover;">
              <?php else: ?>
                <i class="ti ti-user"></i>
                <span><?= h($msg['cargo']) ?></span>
              <?php endif; ?>
            </div>
            <div class="directivo-info">
              <span class="directivo-rol">Mensaje de <?= h($msg['cargo']) ?></span>
              <h3><?= h($msg['nombre']) ?></h3>
              <?php if (!empty($msg['mensaje'])): ?>
                <p><?= h(mb_strimwidth(trim(preg_replace('/\s+/', ' ', $msg['mensaje'])), 0, 180, '…')) ?></p>
              <?php endif; ?>
              <a href="#nosotros" data-page="nosotros">
                Conoce más <i class="ti ti-arrow-right"></i>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="admin-empty">
          <i class="ti ti-users-off"></i>
          <p>Por el momento no hay mensaje institucional publicado.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== GALERÍA ===== -->
<section class="seccion seccion-oscura">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Nuestra comunidad</span>
      <h2>Nuestra vida en la División de Estudios de Posgrado</h2>
    </div>

    <div class="galeria-grid">
      <?php foreach (['galeria_1', 'galeria_2', 'galeria_3', 'galeria_4', 'galeria_5'] as $indice_galeria => $clave_galeria): ?>
        <?php $clase_galeria = $indice_galeria === 0 ? ' galeria-item--large' : ''; ?>
        <?php if (isset($imagenes_sitio[$clave_galeria])): ?>
          <div class="galeria-item<?= $clase_galeria ?>">
            <img src="<?= h(url_subida($imagenes_sitio[$clave_galeria]['imagen_url'])) ?>"
                 alt="<?= h($imagenes_sitio[$clave_galeria]['alt_texto'] ?? 'Comunidad Posgrado FECA') ?>"
                 style="width:100%;height:100%;object-fit:cover;">
          </div>
        <?php else: ?>
          <div class="galeria-item<?= $clase_galeria ?>">
            <i class="ti ti-photo"></i>
            <span>Editable desde el panel · Imágenes del sitio</span>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <div class="seccion-cta" style="margin-top: 32px;">
      <a href="#comunidad" class="btn-outline-white" data-page="comunidad">
        Ver comunidad <i class="ti ti-arrow-right"></i>
      </a>
    </div>
  </div>
</section>
