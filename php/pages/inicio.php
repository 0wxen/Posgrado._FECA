<?php
require_once __DIR__ . '/../includes/content.php';
$noticias         = fetch_public_content(['noticia'], 3);
$convocatorias_db = fetch_public_content(['convocatoria'], 5);
?>

<!-- ===== HERO ===== -->
<section class="hero">
  <div class="hero-inner">
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
</section>

<!-- ===== CONVOCATORIAS ===== -->
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
