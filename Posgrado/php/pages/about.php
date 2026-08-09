<?php
require_once __DIR__ . '/../includes/content.php';
$directivos_db = listar_profesores();
$imagenes_sitio = listar_imagenes_sitio();
$mensajes_institucionales = listar_mensajes_institucionales();
?>
<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Nosotros</h1>
    <p class="page-banner-desc">
      Conoce a nuestro equipo directivo, el organigrama
      y el directorio de la estructura de la División.
    </p>
  </div>
</section>

<!-- ===== MENSAJES INSTITUCIONALES ===== -->
<section class="seccion seccion-gris">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Palabras de nuestra dirección</span>
      <h2>Mensaje Institucional</h2>
    </div>

    <div class="mensaje-grid">
      <?php foreach ($mensajes_institucionales as $msg): ?>
        <div class="mensaje-card">
          <div class="mensaje-card-header">
            <div class="mensaje-foto">
              <?php if (!empty($msg['foto_url'])): ?>
                <img src="<?= h(url_subida($msg['foto_url'] ?? null)) ?>" alt="<?= h($msg['nombre']) ?>" style="width:100%;height:100%;object-fit:cover;">
              <?php else: ?>
                <i class="ti ti-user"></i>
              <?php endif; ?>
            </div>
            <span class="mensaje-cargo"><?= h($msg['cargo']) ?></span>
            <div class="mensaje-nombre"><?= h($msg['nombre']) ?></div>
          </div>
          <div class="mensaje-card-body">
            <p class="mensaje-texto"><?= nl2br(h($msg['mensaje'] ?? '')) ?></p>
            <p class="mensaje-firma">— <?= h($msg['nombre']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===== ORGANIGRAMA ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Estructura institucional</span>
      <h2>Organigrama</h2>
    </div>

    <div class="organigrama-wrapper">
      <?php if (isset($imagenes_sitio['organigrama'])): ?>
        <div class="organigrama-placeholder">
          <img src="<?= h(url_subida($imagenes_sitio['organigrama']['imagen_url'])) ?>" alt="Organigrama División de Estudios de Posgrado FECA UJED">
        </div>
        <a href="<?= h(url_subida($imagenes_sitio['organigrama']['imagen_url'])) ?>" target="_blank" rel="noopener" class="btn-link-rojo" style="margin-top:16px;display:inline-flex;">
          <i class="ti ti-download"></i> Descargar organigrama
        </a>
      <?php else: ?>
        <div class="admin-empty">
          <i class="ti ti-sitemap"></i>
          <p>El organigrama todavía no se ha publicado.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== DIRECTORIO ===== -->
<section class="seccion seccion-gris">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Personal</span>
      <h2>Directorio</h2>
      <p>Estructura de la División de Estudios de Posgrado FECA UJED.</p>
    </div>

    <div class="directorio-grid">
      <?php if (!empty($directivos_db)): ?>
        <?php foreach ($directivos_db as $d): ?>
          <div class="directorio-item">
            <div class="directorio-icon">
              <?php if (!empty($d['foto_url'])): ?>
                <img src="<?= h(url_subida($d['foto_url'] ?? null)) ?>" alt="<?= h($d['nombre']) ?>" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
              <?php else: ?>
                <i class="ti ti-user"></i>
              <?php endif; ?>
            </div>
            <div>
              <div class="directorio-nombre"><?= h($d['nombre']) ?></div>
              <div class="directorio-cargo">
                <?= h($d['titulo_cargo'] ?? '') ?><?php if (!empty($d['email'])): ?> · <?= h($d['email']) ?><?php endif; ?><?php if (!empty($d['telefono_extension'])): ?> · <?= h($d['telefono_extension']) ?><?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>

      <div class="directorio-item">
        <div class="directorio-icon"><i class="ti ti-award"></i></div>
        <div>
          <div class="directorio-nombre">Dr. Jesús Guillermo Sotelo Asef</div>
          <div class="directorio-cargo">Director de la División de Posgrado</div>
        </div>
      </div>

      <div class="directorio-item">
        <div class="directorio-icon"><i class="ti ti-school"></i></div>
        <div>
          <div class="directorio-nombre">Dr. Eliú J. Reyes Reyes</div>
          <div class="directorio-cargo">Jefe de la División de Posgrado</div>
        </div>
      </div>

      <div class="directorio-item">
        <div class="directorio-icon"><i class="ti ti-book"></i></div>
        <div>
          <div class="directorio-nombre">Coordinación Académica</div>
          <div class="directorio-cargo">Nombre · coordacademica@ujed.mx</div>
        </div>
      </div>

      <div class="directorio-item">
        <div class="directorio-icon"><i class="ti ti-flask"></i></div>
        <div>
          <div class="directorio-nombre">Coordinación de Investigación</div>
          <div class="directorio-cargo">Nombre · investigacion@ujed.mx</div>
        </div>
      </div>

      <div class="directorio-item">
        <div class="directorio-icon"><i class="ti ti-users-group"></i></div>
        <div>
          <div class="directorio-nombre">Coordinación de Comunidad</div>
          <div class="directorio-cargo">Nombre · comunidad@ujed.mx</div>
        </div>
      </div>

      <div class="directorio-item">
        <div class="directorio-icon"><i class="ti ti-building"></i></div>
        <div>
          <div class="directorio-nombre">Soporte Administrativo</div>
          <div class="directorio-cargo">posgradofeca@ujed.mx · 618 827 1266</div>
        </div>
      </div>

      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#inicio" class="pnb-prev" data-page="inicio">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Anterior</span>
        <span class="pnb-name">Inicio</span>
      </span>
    </a>
    <a href="#inicio" class="pnb-home" data-page="inicio" title="Volver a Inicio">
      <i class="ti ti-home"></i>
    </a>
    <a href="#oferta_educativa" class="pnb-next" data-page="oferta_educativa">
      <span class="pnb-info">
        <span class="pnb-dir">Siguiente</span>
        <span class="pnb-name">Oferta Educativa</span>
      </span>
      <span class="pnb-arrow"><i class="ti ti-arrow-right"></i></span>
    </a>
  </div>
</nav>
