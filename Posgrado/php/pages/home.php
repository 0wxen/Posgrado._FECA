<?php
require_once __DIR__ . '/../includes/content.php';
$noticias         = fetch_public_content(['noticia'], 3);
$convocatorias_db = fetch_public_content(['convocatoria'], 5);
?>

<?php /* ===== HERO ANTERIOR — deshabilitado el 2026-07-06, se conserva de referencia =====
         Slideshow a pantalla completa con texto superpuesto y velo oscuro. Se reemplazó por
         un diseño de dos columnas (texto institucional a la izquierda, imagen contenida a la
         derecha) porque no convencía el estilo "imagen de fondo + texto encima". */
   if (false): ?>
<section class="hero" id="hero-slideshow">
  <div class="hero-slide activo"
       style="background-image:url('../assets/img/convocatoria-a2025.png')"
       data-conv-title="Maestría en Gestión de Negocios · Ciclo A-2025"
       data-conv-img="../assets/img/convocatoria-a2025.png"
       data-conv-badge="Vigente"
       data-conv-ciclo="Ciclo A-2025"
       data-conv-limite="Límite de registro: 31 de enero de 2025"
       data-conv-desc="Programa orientado al desarrollo de competencias estratégicas para liderar organizaciones en entornos dinámicos y globales. Reconocido por el PNPC-CONAHCyT."
       data-conv-registro="#"
       data-conv-doc="#"></div>

  <div class="hero-slide"
       style="background-image:url('../assets/img/convocatoria-me.png')"
       data-conv-title="Maestría en Economía · Ciclo A-2025"
       data-conv-img="../assets/img/convocatoria-me.png"
       data-conv-badge="Vigente"
       data-conv-ciclo="Ciclo A-2025"
       data-conv-limite="Límite de registro: 15 de enero de 2025"
       data-conv-desc="Desarrolla competencias analíticas avanzadas para comprender y resolver los desafíos económicos regionales y nacionales. Programa PNPC."
       data-conv-registro="#"
       data-conv-doc="#"></div>

  <div class="hero-bg-overlay" title="Ver detalle de convocatoria"></div>

  <div class="hero-progress">
    <div class="hero-progress-bar"><div class="hero-progress-fill"></div></div>
    <div class="hero-progress-bar"><div class="hero-progress-fill"></div></div>
  </div>

  <button class="hero-nav-btn hero-nav-prev" aria-label="Convocatoria anterior">
    <i class="ti ti-chevron-left"></i>
  </button>
  <button class="hero-nav-btn hero-nav-next" aria-label="Siguiente convocatoria">
    <i class="ti ti-chevron-right"></i>
  </button>

  <div class="hero-inner">
    <div class="hero-content">
      <span class="hero-kicker">División de Estudios de Posgrado · FECA · UJED</span>
      <h1 class="hero-title">La herramienta para el futuro<br>que tú deseas</h1>
      <p class="hero-desc">
        Formamos líderes con excelencia académica, investigación y compromiso
        para el desarrollo de la sociedad.
      </p>
      <div class="hero-actions">
        <a href="#convocatorias" class="btn-primary" data-page="convocatorias">
          <i class="ti ti-file-text"></i> Ver Convocatorias
        </a>
        <a href="#nosotros" class="btn-outline-white" data-page="nosotros">
          Conoce más
        </a>
      </div>
      <div class="hero-stats">
        <div>
          <div class="hero-stat-num">5+</div>
          <div class="hero-stat-label">Programas de Posgrado</div>
        </div>
        <div>
          <div class="hero-stat-num">25+</div>
          <div class="hero-stat-label">Años de Trayectoria</div>
        </div>
        <div>
          <div class="hero-stat-num">PNPC</div>
          <div class="hero-stat-label">Reconocimiento Nacional</div>
        </div>
      </div>
    </div>
  </div>

  <a href="#convocatorias" class="hero-conv-cta" data-page="convocatorias">
    <i class="ti ti-sparkles"></i> Ver Convocatorias <i class="ti ti-arrow-right"></i>
  </a>
</section>
<?php endif; /* ===== FIN DEL HERO ANTERIOR ===== */ ?>

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
          <div class="hero-split-stat-num">25+</div>
          <div class="hero-split-stat-label">Años de Trayectoria</div>
        </div>
        <div class="hero-split-stat">
          <div class="hero-split-stat-num">PNPC</div>
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
        $hero_slides = [
          ['title' => 'Maestría en Economía'],
          ['title' => 'Maestría en Gestión de Negocios'],
          ['title' => 'Maestría en Gestión Pública'],
          ['title' => 'Maestría en Estrategias Contables'],
          ['title' => 'Especialidad en Administración de Hospitales'],
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
             data-conv-title="<?= h($hero_conv['title']) ?>"
             data-conv-img=""
             data-conv-badge="Convocatoria Abierta"
             data-conv-ciclo=""
             data-conv-limite=""
             data-conv-desc="<?= h($hero_conv['description'] ?? '') ?>"
             data-conv-registro="#convocatorias"
             data-conv-doc="">
          <div class="hero-split-media" style="--tint1:<?= h($par[0]) ?>; --tint2:<?= h($par[1]) ?>">
            <i class="ti <?= h($icono) ?>"></i>
          </div>
          <div class="hero-split-caption">
            <span class="hero-split-caption-kicker">Convocatoria Abierta</span>
            <span class="hero-split-caption-title"><?= h($hero_conv['title']) ?></span>
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
                  aria-label="Ver <?= h($hero_conv['title']) ?>"></button>
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
        registro: s.dataset.convRegistro,
        doc:      s.dataset.convDoc
      });
    });
  });

  render();
  resetTimer();
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
          <div class="conv-card">
            <span class="conv-badge">Convocatoria Abierta</span>
            <h3><?= h($conv['title']) ?></h3>
            <?php if (!empty($conv['description'])): ?>
              <p><?= h($conv['description']) ?></p>
            <?php endif; ?>
            <div class="conv-card-actions">
              <?php if (!empty($conv['file_path'])): ?>
                <a href="<?= h('../' . ltrim($conv['file_path'], '/')) ?>"
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

        <div class="conv-card">
          <img src="../assets/img/convocatoria-me.png"
               class="conv-card-poster" alt="Convocatoria Maestría en Economía A-2025">
          <span class="conv-badge">Ciclo A-2025</span>
          <h3>Maestría en Economía</h3>
          <p>Desarrolla competencias analíticas para comprender y resolver los desafíos económicos de la región.</p>
          <div class="conv-card-actions">
            <a href="../assets/img/convocatoria-me.png" target="_blank" class="btn-sm-rojo">
              <i class="ti ti-download"></i> Descargar Convocatoria
            </a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Más Información</a>
          </div>
        </div>

        <div class="conv-card">
          <img src="../assets/img/convocatoria-a2025.png"
               class="conv-card-poster" alt="Convocatoria Ciclo A-2025">
          <span class="conv-badge">Ciclo A-2025</span>
          <h3>Maestría en Gestión de Negocios</h3>
          <p>Forma competencias estratégicas para liderar organizaciones en entornos dinámicos y globales.</p>
          <div class="conv-card-actions">
            <a href="../assets/img/convocatoria-a2025.png" target="_blank" class="btn-sm-rojo">
              <i class="ti ti-download"></i> Descargar Convocatoria
            </a>
            <a href="#convocatorias" class="btn-sm-outline" data-page="convocatorias">Más Información</a>
          </div>
        </div>

        <div class="conv-card">
          <span class="conv-badge">Ciclo A-2025</span>
          <h3>Maestría en Gestión Pública</h3>
          <p>Prepara servidores públicos capaces de impulsar el desarrollo y la modernización institucional.</p>
          <div class="conv-card-actions">
            <a href="#" class="btn-sm-rojo"><i class="ti ti-download"></i> Descargar Convocatoria</a>
            <a href="#" class="btn-sm-outline" data-page="convocatorias">Más Información</a>
          </div>
        </div>

        <div class="conv-card">
          <span class="conv-badge">Ciclo A-2025</span>
          <h3>Maestría en Estrategias Contables</h3>
          <p>Especialízate en análisis financiero y planeación fiscal para una toma de decisiones efectiva.</p>
          <div class="conv-card-actions">
            <a href="#" class="btn-sm-rojo"><i class="ti ti-download"></i> Descargar Convocatoria</a>
            <a href="#" class="btn-sm-outline" data-page="convocatorias">Más Información</a>
          </div>
        </div>

        <div class="conv-card">
          <span class="conv-badge">Ciclo A-2025</span>
          <h3>Especialidad en Administración de Hospitales</h3>
          <p>Desarrolla habilidades de gestión en salud para mejorar la calidad de la atención hospitalaria.</p>
          <div class="conv-card-actions">
            <a href="#" class="btn-sm-rojo"><i class="ti ti-download"></i> Descargar Convocatoria</a>
            <a href="#" class="btn-sm-outline" data-page="convocatorias">Más Información</a>
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

<?php /* ===== DISEÑO v5 — deshabilitado el 2026-07-06, se conserva de referencia =====
         Banner de imágenes horizontales (carrusel) + convocatorias en tarjetas oscuras con
         contador regresivo. Se reemplazó porque se decidió volver al diseño original: hero
         con texto institucional superpuesto + convocatorias en tarjetas simples. */
   if (false): ?>
<section class="hero3" id="hero-inicio">
  <div class="hero3-viewport" id="hero3-viewport">

    <!-- Cada slide admite una imagen horizontal real (banner) más adelante:
         basta con agregar <img class="hero3-slide-img" src="..."> dentro y quitar
         el bloque .hero3-slide-media--placeholder. -->
    <div class="hero3-slide activo">
      <div class="hero3-slide-media hero3-slide-media--placeholder" style="--tint1:#8a0e17; --tint2:#2b0a0a">
        <i class="ti ti-photo"></i>
        <span>Banner institucional — imagen horizontal próximamente</span>
      </div>
      <div class="hero3-slide-caption">
        <span class="hero3-slide-kicker">División de Estudios de Posgrado · FECA · UJED</span>
        <h2 class="hero3-slide-title">División de Estudios de Posgrado</h2>
      </div>
    </div>

    <div class="hero3-slide">
      <div class="hero3-slide-media hero3-slide-media--placeholder" style="--tint1:#8a6423; --tint2:#3a2a0d">
        <i class="ti ti-photo"></i>
        <span>Banner institucional — imagen horizontal próximamente</span>
      </div>
      <div class="hero3-slide-caption">
        <span class="hero3-slide-kicker">División de Estudios de Posgrado · FECA · UJED</span>
        <h2 class="hero3-slide-title">Facultad de Economía, Contaduría y Administración</h2>
      </div>
    </div>

  </div>

  <button class="hero3-nav hero3-nav-prev" aria-label="Banner anterior"><i class="ti ti-chevron-left"></i></button>
  <button class="hero3-nav hero3-nav-next" aria-label="Banner siguiente"><i class="ti ti-chevron-right"></i></button>

  <div class="hero3-dots">
    <button class="hero3-dot activo" data-goto="0" aria-label="Ir al banner 1"></button>
    <button class="hero3-dot" data-goto="1" aria-label="Ir al banner 2"></button>
  </div>
</section>

<script>
(function () {
  var hero = document.getElementById('hero3-viewport');
  if (!hero) return;
  var slides = hero.querySelectorAll('.hero3-slide');
  var dots   = document.querySelectorAll('.hero3-dots .hero3-dot');
  var btnPrev = document.querySelector('.hero3-nav-prev');
  var btnNext = document.querySelector('.hero3-nav-next');
  if (!slides.length) return;
  var current = 0;
  var timer;
  var DURACION = 5000;

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

  if (btnPrev) btnPrev.addEventListener('click', function () { goTo(current - 1); resetTimer(); });
  if (btnNext) btnNext.addEventListener('click', function () { goTo(current + 1); resetTimer(); });
  dots.forEach(function (d, i) {
    d.addEventListener('click', function () { goTo(i); resetTimer(); });
  });

  render();
  resetTimer();
})();
</script>

<!-- ===== CONVOCATORIAS — debajo del banner institucional, alimentadas desde la base de datos ===== -->
<section class="convs-section" id="hero2-convs">
  <div class="inner">

    <div class="hero2-convs-heading">
      <span class="hero2-convs-eyebrow"><span class="dot"></span> Convocatorias vigentes</span>
      <h2 class="hero2-convs-title">Convocatorias Abiertas</h2>
      <p class="hero2-convs-sub">Consulta los programas con admisión abierta e inscríbete para el próximo ciclo escolar.</p>
    </div>

    <div class="hero2-convs-track">
        <?php
          $acentos = ['#e31313', '#a87f3d', '#2f6fb0'];
          $indice_acento = 0;
        ?>
        <?php if (!empty($convocatorias_db)): ?>

          <?php foreach ($convocatorias_db as $conv): ?>
            <?php
              $doc    = !empty($conv['file_path']) ? '../' . ltrim($conv['file_path'], '/') : '';
              $acento = $acentos[$indice_acento % count($acentos)];
              $indice_acento++;
            ?>
            <div class="hero2-conv-card" role="button" tabindex="0" style="--accent:<?= h($acento) ?>"
                 data-conv-title="<?= h($conv['title']) ?>"
                 data-conv-img=""
                 data-conv-badge="Convocatoria Abierta"
                 data-conv-ciclo=""
                 data-conv-limite=""
                 data-conv-desc="<?= h($conv['description']) ?>"
                 data-conv-registro="#convocatorias"
                 data-conv-doc="<?= h($doc) ?>">
              <div class="hero2-conv-top">
                <span class="hero2-conv-icon"><i class="ti ti-file-text"></i></span>
              </div>
              <h3><?= h($conv['title']) ?></h3>
              <?php if (!empty($conv['description'])): ?>
                <p><?= h($conv['description']) ?></p>
              <?php endif; ?>
              <span class="hero2-conv-footer">
                <?php if ($doc !== ''): ?>
                  <a href="<?= h($doc) ?>" target="_blank" rel="noopener" class="hero2-conv-btn" onclick="event.stopPropagation()">
                    <i class="ti ti-download"></i> Descargar convocatoria
                  </a>
                <?php endif; ?>
                <span class="hero2-conv-more-btn">Ver detalle <i class="ti ti-arrow-right"></i></span>
              </span>
            </div>
          <?php endforeach; ?>

        <?php else: ?>

          <!-- Respaldo mientras no haya convocatorias publicadas en la base de datos -->
          <div class="hero2-conv-card" role="button" tabindex="0" style="--accent:#e31313"
               data-conv-title="Maestría en Economía · Ciclo A-2025" data-conv-img=""
               data-conv-badge="Ciclo A-2025" data-conv-ciclo="Ciclo A-2025" data-conv-limite=""
               data-conv-desc="Desarrolla competencias analíticas para comprender y resolver los desafíos económicos de la región."
               data-conv-registro="#convocatorias" data-conv-doc="../assets/img/convocatoria-me.png">
            <div class="hero2-conv-top">
              <span class="hero2-conv-icon"><i class="ti ti-chart-line"></i></span>
            </div>
            <h3>Maestría en Economía</h3>
            <p>Desarrolla competencias analíticas para comprender y resolver los desafíos económicos de la región.</p>
            <span class="hero2-conv-footer">
              <a href="../assets/img/convocatoria-me.png" target="_blank" class="hero2-conv-btn" onclick="event.stopPropagation()">
                <i class="ti ti-download"></i> Descargar convocatoria
              </a>
              <span class="hero2-conv-more-btn">Ver detalle <i class="ti ti-arrow-right"></i></span>
            </span>
          </div>

          <div class="hero2-conv-card" role="button" tabindex="0" style="--accent:#a87f3d"
               data-conv-title="Maestría en Gestión de Negocios · Ciclo A-2025" data-conv-img=""
               data-conv-badge="Ciclo A-2025" data-conv-ciclo="Ciclo A-2025" data-conv-limite=""
               data-conv-desc="Forma competencias estratégicas para liderar organizaciones en entornos dinámicos y globales."
               data-conv-registro="#convocatorias" data-conv-doc="../assets/img/convocatoria-a2025.png">
            <div class="hero2-conv-top">
              <span class="hero2-conv-icon"><i class="ti ti-briefcase"></i></span>
            </div>
            <h3>Maestría en Gestión de Negocios</h3>
            <p>Forma competencias estratégicas para liderar organizaciones en entornos dinámicos y globales.</p>
            <span class="hero2-conv-footer">
              <a href="../assets/img/convocatoria-a2025.png" target="_blank" class="hero2-conv-btn" onclick="event.stopPropagation()">
                <i class="ti ti-download"></i> Descargar convocatoria
              </a>
              <span class="hero2-conv-more-btn">Ver detalle <i class="ti ti-arrow-right"></i></span>
            </span>
          </div>

          <div class="hero2-conv-card" role="button" tabindex="0" style="--accent:#2f6fb0"
               data-conv-title="Maestría en Gestión Pública · Ciclo A-2025" data-conv-img=""
               data-conv-badge="Ciclo A-2025" data-conv-ciclo="Ciclo A-2025" data-conv-limite=""
               data-conv-desc="Prepara servidores públicos capaces de impulsar el desarrollo y la modernización institucional."
               data-conv-registro="#convocatorias" data-conv-doc="">
            <div class="hero2-conv-top">
              <span class="hero2-conv-icon"><i class="ti ti-building-community"></i></span>
            </div>
            <h3>Maestría en Gestión Pública</h3>
            <p>Prepara servidores públicos capaces de impulsar el desarrollo y la modernización institucional.</p>
            <span class="hero2-conv-footer">
              <span class="hero2-conv-more-btn">Ver detalle <i class="ti ti-arrow-right"></i></span>
            </span>
          </div>

          <div class="hero2-conv-card" role="button" tabindex="0" style="--accent:#e31313"
               data-conv-title="Maestría en Estrategias Contables · Ciclo A-2025" data-conv-img=""
               data-conv-badge="Ciclo A-2025" data-conv-ciclo="Ciclo A-2025" data-conv-limite=""
               data-conv-desc="Especialízate en análisis financiero y planeación fiscal para una toma de decisiones efectiva."
               data-conv-registro="#convocatorias" data-conv-doc="">
            <div class="hero2-conv-top">
              <span class="hero2-conv-icon"><i class="ti ti-calculator"></i></span>
            </div>
            <h3>Maestría en Estrategias Contables</h3>
            <p>Especialízate en análisis financiero y planeación fiscal para una toma de decisiones efectiva.</p>
            <span class="hero2-conv-footer">
              <span class="hero2-conv-more-btn">Ver detalle <i class="ti ti-arrow-right"></i></span>
            </span>
          </div>

          <div class="hero2-conv-card" role="button" tabindex="0" style="--accent:#a87f3d"
               data-conv-title="Especialidad en Administración de Hospitales · Ciclo A-2025" data-conv-img=""
               data-conv-badge="Ciclo A-2025" data-conv-ciclo="Ciclo A-2025" data-conv-limite=""
               data-conv-desc="Desarrolla habilidades de gestión en salud para mejorar la calidad de la atención hospitalaria."
               data-conv-registro="#convocatorias" data-conv-doc="">
            <div class="hero2-conv-top">
              <span class="hero2-conv-icon"><i class="ti ti-heartbeat"></i></span>
            </div>
            <h3>Especialidad en Administración de Hospitales</h3>
            <p>Desarrolla habilidades de gestión en salud para mejorar la calidad de la atención hospitalaria.</p>
            <span class="hero2-conv-footer">
              <span class="hero2-conv-more-btn">Ver detalle <i class="ti ti-arrow-right"></i></span>
            </span>
          </div>

        <?php endif; ?>
      </div>

    <!-- Identidad institucional — cierra la sección de convocatorias -->
    <div class="hero2-bottombar">
      <div class="hero2-bottombar-row">
        <span class="hero2-bottombar-kicker">División de Estudios de Posgrado · FECA · UJED</span>
        <div class="hero2-bottombar-right">
          <span class="hero2-chip"><b>5+</b> Programas</span>
          <span class="hero2-chip"><b>25+</b> Años</span>
          <span class="hero2-chip"><b>PNPC</b> Reconocimiento</span>
          <a href="#nosotros" class="hero2-bottombar-more" data-page="nosotros">Conoce más <i class="ti ti-arrow-right"></i></a>
        </div>
      </div>
      <p class="hero2-tagline"><i class="ti ti-quote"></i> La herramienta para el futuro que tú deseas</p>
    </div>

  </div>
</section>

<script>
(function () {
  var cards = document.querySelectorAll('#hero2-convs .hero2-conv-card');
  cards.forEach(function (c) {
    function abrir() {
      if (typeof window.openConvModal !== 'function') return;
      window.openConvModal({
        img:      c.dataset.convImg,
        badge:    c.dataset.convBadge,
        title:    c.dataset.convTitle,
        ciclo:    c.dataset.convCiclo,
        limite:   c.dataset.convLimite,
        desc:     c.dataset.convDesc,
        registro: c.dataset.convRegistro,
        doc:      c.dataset.convDoc
      });
    }
    c.addEventListener('click', abrir);
    c.addEventListener('keyup', function (e) {
      if (e.key === 'Enter' || e.key === ' ') abrir();
    });
  });
})();
</script>
<?php endif; /* ===== FIN DEL DISEÑO v5 ===== */ ?>

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
              <?php if (!empty($noticia['file_path']) && str_starts_with((string) $noticia['mime_type'], 'image/')): ?>
                <img src="<?= h('../' . ltrim($noticia['file_path'], '/')) ?>"
                     alt="<?= h($noticia['title']) ?>">
              <?php else: ?>
                <i class="ti ti-news"></i>
                <span>Imagen de noticia</span>
              <?php endif; ?>
            </div>
            <div class="noticia-body">
              <span class="noticia-tag">Noticia</span>
              <h3><?= h($noticia['title']) ?></h3>
              <?php if (!empty($noticia['description'])): ?>
                <p><?= h(mb_strimwidth($noticia['description'], 0, 110, '…')) ?></p>
              <?php endif; ?>
              <a href="#blog" class="noticia-leer" data-page="blog">
                Leer más <i class="ti ti-arrow-right"></i>
              </a>
            </div>
          </article>
        <?php endforeach; ?>

      <?php else: ?>

        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-news"></i><span>Imagen de noticia</span></div>
          <div class="noticia-body">
            <span class="noticia-tag">Noticia</span>
            <h3>Abierta la convocatoria para el Ciclo A-2025 para ME</h3>
            <p>El programa de Maestría en Economía abre su proceso de admisión para el próximo ciclo escolar con nuevas modalidades.</p>
            <a href="#blog" class="noticia-leer" data-page="blog">Leer más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>

        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-news"></i><span>Imagen de noticia</span></div>
          <div class="noticia-body">
            <span class="noticia-tag">Noticia</span>
            <h3>Nuevo programa de posgrado: Maestría en Economía</h3>
            <p>La División incorpora un nuevo programa reconocido a nivel nacional con el sello de calidad del PNPC-CONAHCYT.</p>
            <a href="#blog" class="noticia-leer" data-page="blog">Leer más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>

        <article class="noticia-card">
          <div class="noticia-img"><i class="ti ti-news"></i><span>Imagen de noticia</span></div>
          <div class="noticia-body">
            <span class="noticia-tag">Noticia</span>
            <h3>Convocatoria Ciclo A-2025 para MGN, MGP, MEC y EAH</h3>
            <p>Cuatro programas de posgrado abren simultáneamente su proceso de admisión. Descarga la convocatoria de tu interés.</p>
            <a href="#blog" class="noticia-leer" data-page="blog">Leer más <i class="ti ti-arrow-right"></i></a>
          </div>
        </article>

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

      <div class="directivo-card">
        <div class="directivo-foto">
          <!-- Coloca la imagen en: assets/img/director.jpg -->
          <i class="ti ti-user"></i>
          <span>Director</span>
        </div>
        <div class="directivo-info">
          <span class="directivo-rol">Mensaje del Director</span>
          <h3>Dr. José Ramón Duarte Carranza</h3>
          <p>
            Bienvenido a la División de Estudios de Posgrado. Nuestra misión es
            formar profesionales con visión global y un compromiso genuino con
            el desarrollo de nuestra región.
          </p>
          <a href="#nosotros" data-page="nosotros">
            Conoce más <i class="ti ti-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="directivo-card">
        <div class="directivo-foto">
          <!-- Coloca la imagen en: assets/img/jefa-posgrado.jpg -->
          <i class="ti ti-user"></i>
          <span>Jefa de Posgrado</span>
        </div>
        <div class="directivo-info">
          <span class="directivo-rol">Mensaje de la Jefa de Posgrado</span>
          <h3>Dra. Jessica Yocaste Castañeda Galván</h3>
          <p>
            Los invitamos a ser parte de nuestra comunidad académica, donde el
            rigor investigativo y la excelencia son el camino hacia el futuro
            que deseas.
          </p>
          <a href="#nosotros" data-page="nosotros">
            Conoce más <i class="ti ti-arrow-right"></i>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
(function () {
  var hero    = document.getElementById('hero-slideshow');
  if (!hero) return;
  var slides  = hero.querySelectorAll('.hero-slide');
  var fills   = hero.querySelectorAll('.hero-progress-fill');
  var bars    = hero.querySelectorAll('.hero-progress-bar');
  var overlay = hero.querySelector('.hero-bg-overlay');
  var btnPrev = hero.querySelector('.hero-nav-prev');
  var btnNext = hero.querySelector('.hero-nav-next');
  if (!slides.length) return;
  var current = 0;
  var timer;
  var DURACION = 3200;

  function render() {
    slides.forEach(function (s, i) { s.classList.toggle('activo', i === current); });
    fills.forEach(function (f, i) {
      f.classList.remove('completo', 'corriendo');
      if (i < current) {
        f.classList.add('completo');
      } else if (i === current) {
        void f.offsetWidth; // reinicia la animación
        f.classList.add('corriendo');
      }
    });
  }

  function goTo(idx) {
    current = (idx + slides.length) % slides.length;
    render();
  }

  function resetTimer() {
    clearInterval(timer);
    timer = setInterval(function () { goTo(current + 1); }, DURACION);
  }

  function abrirModal() {
    if (typeof window.openConvModal !== 'function') return;
    var s = slides[current];
    window.openConvModal({
      img:      s.dataset.convImg,
      badge:    s.dataset.convBadge,
      title:    s.dataset.convTitle,
      ciclo:    s.dataset.convCiclo,
      limite:   s.dataset.convLimite,
      desc:     s.dataset.convDesc,
      registro: s.dataset.convRegistro,
      doc:      s.dataset.convDoc
    });
  }

  if (btnPrev) btnPrev.addEventListener('click', function (e) { e.stopPropagation(); goTo(current - 1); resetTimer(); });
  if (btnNext) btnNext.addEventListener('click', function (e) { e.stopPropagation(); goTo(current + 1); resetTimer(); });
  bars.forEach(function (bar, i) {
    bar.addEventListener('click', function (e) { e.stopPropagation(); goTo(i); resetTimer(); });
  });
  if (overlay) overlay.addEventListener('click', abrirModal);

  render();
  resetTimer();
})();
</script>

<!-- ===== GALERÍA ===== -->
<section class="seccion seccion-oscura">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Nuestra comunidad</span>
      <h2>Nuestra vida en la División de Estudios de Posgrado</h2>
    </div>

    <div class="galeria-grid">
      <!-- Imagen principal grande — coloca en: assets/img/galeria-1.jpg -->
      <div class="galeria-item galeria-item--large">
        <i class="ti ti-photo"></i>
        <span>Imagen principal · assets/img/galeria-1.jpg</span>
      </div>
      <!-- Imagen 2 — assets/img/galeria-2.jpg -->
      <div class="galeria-item">
        <i class="ti ti-photo"></i>
        <span>assets/img/galeria-2.jpg</span>
      </div>
      <!-- Imagen 3 — assets/img/galeria-3.jpg -->
      <div class="galeria-item">
        <i class="ti ti-photo"></i>
        <span>assets/img/galeria-3.jpg</span>
      </div>
      <!-- Imagen 4 — assets/img/galeria-4.jpg -->
      <div class="galeria-item">
        <i class="ti ti-photo"></i>
        <span>assets/img/galeria-4.jpg</span>
      </div>
      <!-- Imagen 5 — assets/img/galeria-5.jpg -->
      <div class="galeria-item">
        <i class="ti ti-photo"></i>
        <span>assets/img/galeria-5.jpg</span>
      </div>
    </div>

    <div class="seccion-cta" style="margin-top: 32px;">
      <a href="#comunidad" class="btn-outline-white" data-page="comunidad">
        Ver comunidad <i class="ti ti-arrow-right"></i>
      </a>
    </div>
  </div>
</section>
