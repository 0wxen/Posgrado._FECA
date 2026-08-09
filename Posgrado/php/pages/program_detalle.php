<?php
require_once __DIR__ . '/../includes/content.php';

const NIVEL_CLASE_DET    = ['doctorado' => 'level-doc', 'especialidad' => 'level-esp', 'maestria' => ''];
const NIVEL_ETIQUETA_DET = ['doctorado' => 'Doctorado', 'especialidad' => 'Especialidad', 'maestria' => 'Maestría'];
const MODALIDAD_ETIQUETA_DET = ['presencial' => 'Presencial', 'virtual' => 'Virtual', 'mixta' => 'Mixta'];

$codigo   = strtoupper(trim((string) ($_GET['codigo'] ?? '')));
$programa = $codigo !== '' ? obtener_programa_por_codigo($codigo) : null;

function bullets_desde_texto(?string $texto): array {
  if ($texto === null || trim($texto) === '') return [];
  $lineas = preg_split('/\r\n|\r|\n/', $texto);
  return array_values(array_filter(array_map('trim', $lineas), fn($l) => $l !== ''));
}
?>

<?php if ($programa === null): ?>

<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <h1>Programa no encontrado</h1>
  </div>
</section>
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="admin-empty">
      <i class="ti ti-school-off"></i>
      <p>Este programa ya no está disponible o no existe. Vuelve a Oferta Educativa para ver los programas vigentes.</p>
    </div>
  </div>
</section>

<?php else:
  $titulacion    = listar_titulacion_programa((int) $programa['id']);
  $campoLaboral  = listar_campo_laboral_programa((int) $programa['id']);
  $bulletsIngreso = bullets_desde_texto($programa['perfil_ingreso'] ?? null);
  $bulletsEgreso  = bullets_desde_texto($programa['perfil_egreso'] ?? null);
  $nivelClase     = NIVEL_CLASE_DET[$programa['nivel']] ?? '';
  $nivelEtiqueta  = NIVEL_ETIQUETA_DET[$programa['nivel']] ?? ucfirst((string) $programa['nivel']);
  $modalidadEtiqueta = MODALIDAD_ETIQUETA_DET[$programa['modalidad']] ?? $programa['modalidad'];
?>

<!-- ===== BANNER ===== -->
<section class="page-banner">
  <div class="page-banner-inner">
    <span class="page-banner-kicker">FECA UJED · División de Estudios de Posgrado</span>
    <div style="display:flex;gap:8px;align-items:center;margin-bottom:12px;flex-wrap:wrap;">
      <span class="program-level <?= h($nivelClase) ?>" style="font-size:12px;padding:5px 14px;"><?= h($nivelEtiqueta) ?></span>
      <?php if (!empty($programa['acreditacion'])): ?>
        <span class="program-pnpc"><i class="ti ti-award"></i> <?= h($programa['acreditacion']) ?></span>
      <?php endif; ?>
    </div>
    <h1><?= h($programa['nombre']) ?></h1>
    <?php if (!empty($programa['descripcion'])): ?>
      <p class="page-banner-desc"><?= h($programa['descripcion']) ?></p>
    <?php endif; ?>
  </div>
</section>

<!-- ===== OBJETIVO ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">
    <div style="display:grid;grid-template-columns:1fr 280px;gap:48px;align-items:start;">
      <div>
        <div class="seccion-header" style="margin-bottom:20px;">
          <span class="kicker">Objetivo General</span>
          <h2>¿Qué busca este programa?</h2>
        </div>
        <p style="font-size:16px;color:#555;line-height:1.8;">
          <?= !empty($programa['objetivo']) ? nl2br(h($programa['objetivo'])) : 'Información próximamente disponible.' ?>
        </p>
      </div>
      <div style="display:flex;flex-direction:column;gap:12px;">
        <?php if (!empty($programa['duracion_semestres'])): ?>
          <div class="directorio-item">
            <div class="directorio-icon"><i class="ti ti-clock"></i></div>
            <div><div class="directorio-nombre">Duración</div><div class="directorio-cargo"><?= (int) $programa['duracion_semestres'] ?> semestres</div></div>
          </div>
        <?php endif; ?>
        <?php if (!empty($programa['modalidad'])): ?>
          <div class="directorio-item">
            <div class="directorio-icon"><i class="ti ti-building-university"></i></div>
            <div><div class="directorio-nombre">Modalidad</div><div class="directorio-cargo"><?= h($modalidadEtiqueta) ?></div></div>
          </div>
        <?php endif; ?>
        <?php if (!empty($programa['acreditacion'])): ?>
          <div class="directorio-item">
            <div class="directorio-icon"><i class="ti ti-star"></i></div>
            <div><div class="directorio-nombre">Acreditación</div><div class="directorio-cargo"><?= h($programa['acreditacion']) ?></div></div>
          </div>
        <?php endif; ?>
        <div class="directorio-item">
          <div class="directorio-icon"><i class="ti ti-map-pin"></i></div>
          <div><div class="directorio-nombre">Sede</div><div class="directorio-cargo">Durango, Dgo.</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== PERFILES ===== -->
<section class="seccion seccion-gris">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Perfiles del Estudiante</span>
      <h2>Perfil de Ingreso y Egreso</h2>
    </div>
    <div class="mv-grid">
      <div class="mv-card mv-card--mision">
        <span class="mv-card-deco">IN</span>
        <i class="ti ti-user-check mv-card-icon"></i>
        <h3>Perfil de Ingreso</h3>
        <p>
          <?php if ($bulletsIngreso !== []): ?>
            Al ingresar a <?= h($programa['nombre']) ?>, el aspirante deberá contar con:
            <br><br>
            <?php foreach ($bulletsIngreso as $item): ?>
              · <?= h($item) ?><br>
            <?php endforeach; ?>
          <?php else: ?>
            Información próximamente disponible.
          <?php endif; ?>
        </p>
      </div>
      <div class="mv-card mv-card--vision">
        <span class="mv-card-deco">EG</span>
        <i class="ti ti-certificate mv-card-icon"></i>
        <h3>Perfil de Egreso</h3>
        <p>
          <?php if ($bulletsEgreso !== []): ?>
            El egresado de <?= h($programa['nombre']) ?> tendrá las competencias para:
            <br><br>
            <?php foreach ($bulletsEgreso as $item): ?>
              · <?= h($item) ?><br>
            <?php endforeach; ?>
          <?php else: ?>
            Información próximamente disponible.
          <?php endif; ?>
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ===== TITULACIÓN ===== -->
<section class="seccion seccion-blanca">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Titulación</span>
      <h2>Modalidades de Titulación</h2>
    </div>
    <?php if ($titulacion !== []): ?>
      <div class="recursos-grid">
        <?php foreach ($titulacion as $t): ?>
          <div class="recurso-card">
            <div class="recurso-icon tipo-doc"><i class="ti <?= h($t['icono'] ?: 'ti-file-text') ?>"></i></div>
            <div class="recurso-info">
              <h4><?= h($t['titulo']) ?></h4>
              <?php if (!empty($t['descripcion'])): ?><p><?= h($t['descripcion']) ?></p><?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <p style="font-size:11px;color:#aaa;margin-top:18px;line-height:1.7;border-top:1px solid #eee;padding-top:14px;">* Los estudiantes que concluyan satisfactoriamente el plan de estudios podrán obtener el grado mediante elaboración de trabajo terminal (tesis) o a través de la certificación de competencias profesionales ante el Consejo Nacional de Normalización y Certificación de Competencias Laborales (CONOCER), que ofrece el Centro de Innovación, Investigación, Emprendimiento y Desarrollo Organizacional (CIIEDO) de la Facultad de Economía, Contaduría y Administración, conforme a estándares de competencia alineados al perfil del programa.</p>
  </div>
</section>

<!-- ===== CAMPO LABORAL ===== -->
<section class="seccion seccion-gris">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Mercado Laboral</span>
      <h2>Campo de Acción Profesional</h2>
    </div>
    <?php if ($campoLaboral !== []): ?>
      <div class="directorio-grid">
        <?php foreach ($campoLaboral as $c): ?>
          <div class="directorio-item">
            <div class="directorio-icon"><i class="ti <?= h($c['icono'] ?: 'ti-briefcase') ?>"></i></div>
            <div><div class="directorio-nombre"><?= h($c['titulo']) ?></div><?php if (!empty($c['descripcion'])): ?><div class="directorio-cargo"><?= h($c['descripcion']) ?></div><?php endif; ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="admin-empty">
        <i class="ti ti-briefcase-off"></i>
        <p>Información próximamente disponible.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ===== INSCRIPCIÓN ===== -->
<section class="seccion seccion-oscura">
  <div class="inner">
    <div class="seccion-header">
      <span class="kicker">Admisión</span>
      <h2>Proceso de Inscripción</h2>
    </div>
    <div class="directorio-grid" style="margin-bottom:32px;">
      <div class="directorio-item" style="background:#2a2a2a;border-left-color:var(--rojo);">
        <div class="directorio-icon" style="background:rgba(227,19,19,0.15);color:var(--rojo);font-family:'Barlow Condensed',sans-serif;font-size:22px;font-weight:700;">1</div>
        <div><div class="directorio-nombre" style="color:#fff;">Documentación</div><div class="directorio-cargo" style="color:#aaa;">Presentar la documentación de registro que la División solicite, entre esta poseer el grado de estudios profesionales.</div></div>
      </div>
      <div class="directorio-item" style="background:#2a2a2a;border-left-color:var(--dorado);">
        <div class="directorio-icon" style="background:rgba(168,127,61,0.15);color:var(--dorado);font-family:'Barlow Condensed',sans-serif;font-size:22px;font-weight:700;">2</div>
        <div><div class="directorio-nombre" style="color:#fff;">Pago</div><div class="directorio-cargo" style="color:#aaa;">Realizar el pago correspondiente al proceso de admisión.</div></div>
      </div>
      <div class="directorio-item" style="background:#2a2a2a;border-left-color:var(--dorado);">
        <div class="directorio-icon" style="background:rgba(168,127,61,0.15);color:var(--dorado);font-family:'Barlow Condensed',sans-serif;font-size:22px;font-weight:700;">3</div>
        <div><div class="directorio-nombre" style="color:#fff;">Admisión</div><div class="directorio-cargo" style="color:#aaa;">Acreditar: <?= h($programa['admision_nota'] ?: 'Curso propedéutico · Entrevista.') ?></div></div>
      </div>
    </div>
    <p style="font-size:11px;color:rgba(255,255,255,0.45);margin-bottom:18px;line-height:1.7;border-top:1px solid rgba(255,255,255,0.1);padding-top:14px;">* Los estudiantes que concluyan satisfactoriamente el plan de estudios podrán obtener el grado mediante elaboración de trabajo terminal (tesis) o a través de la certificación de competencias profesionales ante el Consejo Nacional de Normalización y Certificación de Competencias Laborales (CONOCER), que ofrece el Centro de Innovación, Investigación, Emprendimiento y Desarrollo Organizacional (CIIEDO) de la Facultad de Economía, Contaduría y Administración, conforme a estándares de competencia alineados al perfil del programa.</p>
    <div style="display:flex;gap:14px;flex-wrap:wrap;">
      <a href="#convocatorias" class="btn-primary" data-page="convocatorias"><i class="ti ti-file-description"></i> Ver Convocatorias</a>
      <a href="mailto:posgradofeca@ujed.mx" class="btn-outline-white"><i class="ti ti-mail"></i> posgradofeca@ujed.mx</a>
    </div>
  </div>
</section>

<?php endif; ?>

<!-- ===== NAVEGACIÓN INFERIOR ===== -->
<nav class="page-nav-bottom">
  <div class="inner">
    <a href="#oferta_educativa" class="pnb-prev" data-page="oferta_educativa">
      <span class="pnb-arrow"><i class="ti ti-arrow-left"></i></span>
      <span class="pnb-info">
        <span class="pnb-dir">Volver a</span>
        <span class="pnb-name">Oferta Educativa</span>
      </span>
    </a>
    <a href="#inicio" class="pnb-home" data-page="inicio" title="Inicio"><i class="ti ti-home"></i></a>
    <a href="#convocatorias" class="pnb-next" data-page="convocatorias">
      <span class="pnb-info">
        <span class="pnb-dir">Siguiente</span>
        <span class="pnb-name">Convocatorias</span>
      </span>
      <span class="pnb-arrow"><i class="ti ti-arrow-right"></i></span>
    </a>
  </div>
</nav>
