// ── Rutas ────────────────────────────────────────────────────────────────────
// PHP server (puerto 8001) — para contenido dinámico con base de datos.
// Static pages — respaldo HTML que funciona directamente en Live Server.
const PHP_SERVER  = 'http://127.0.0.1:8001';
const _base       = location.pathname.replace(/\/html\/[^/]+$/, '');   // '' ó '/Posgrado'
const PHP_PAGES   = (location.port === '8001' || location.port === '80' || location.port === '')
                      ? '/php/pages/'
                      : PHP_SERVER + '/php/pages/';
const STATIC_PAGES = _base + '/pages/';

const PAGE_FILE_MAP = {
  inicio:              'home',
  nosotros:            'about',
  oferta_educativa:    'educational_offer',
  investigacion:       'research',
  comunidad:           'community',
  contacto:            'contact',
  aviso_privacidad:    'privacy_notice',
  terminos:            'terms',
  mapa_sitio:          'sitemap',
  transparencia:       'transparency',
  convocatorias:       'announcements',
  publicaciones:       'publications',
  cuerpos_academicos:  'academic_bodies',
  grupos_disciplinares:'disciplinary_groups',
  perfiles:            'profile',
  admin:               'admin',
  titulacion:          'titulacion',
  // Páginas de detalle de cada programa
  programa_dgo:        'program_dgo',
  programa_eah:        'program_eah',
  programa_mag:        'program_mag',
  programa_me:         'program_me',
  programa_mec:        'program_mec',
  programa_mgn:        'program_mgn',
  programa_mgp:        'program_mgp',
  programa_mm:         'program_mm',
};

function getPageFile(pagina) {
  return PAGE_FILE_MAP[pagina] ?? pagina;
}

function registrarVisita(pageId) {
  try {
    var stats = JSON.parse(localStorage.getItem('dep_stats_v1') || '{}');
    stats[pageId] = (stats[pageId] || 0) + 1;
    localStorage.setItem('dep_stats_v1', JSON.stringify(stats));
  } catch (_) {}
}

// Intenta PHP (con timeout de 3 s); si falla, carga el .html estático.
async function fetchContenido(nombre) {
  if (location.port !== '8001' && location.port !== '80' && location.port !== '') {
    // Intentar PHP server (cross-origin con CORS)
    try {
      const ctrl = new AbortController();
      const tid  = setTimeout(() => ctrl.abort(), 3000);
      const r    = await fetch(PHP_PAGES + nombre + '.php', { signal: ctrl.signal });
      clearTimeout(tid);
      if (r.ok) return await r.text();
    } catch (_) {
      // PHP server no disponible → continuar al respaldo estático
    }
  } else {
    // Mismo servidor PHP: ruta directa
    const r = await fetch(PHP_PAGES + nombre + '.php');
    if (r.ok) return await r.text();
    throw new Error('HTTP ' + r.status);
  }

  // ── Respaldo: página HTML estática ──────────────────────────────────────
  const r2 = await fetch(STATIC_PAGES + nombre + '.html');
  if (!r2.ok) throw new Error('HTTP ' + r2.status);
  return await r2.text();
}

var PG_FRASES = [
  'Tu futuro académico está a un paso…',
  'El conocimiento que buscas está en camino.',
  'Los grandes logros requieren un poco de paciencia.',
  'Cargando las oportunidades de tu vida.',
  'Tu dedicación hoy construye el éxito de mañana.',
  'La excelencia académica siempre vale la espera.',
  'Cada segundo invertido en aprender cuenta.',
  'Sigue soñando en grande, ya casi estamos.',
  'El camino al éxito pasa por la preparación.',
  'Estamos listos para acompañarte en este camino.',
  'Tu próxima gran decisión está a punto de cargarse.',
  'Invertir en educación es la mejor decisión que puedes tomar.',
  'Preparando todo para ti. ¡Un momento!',
  'Los líderes de mañana se forman hoy aquí.',
  'La División de Posgrado FECA te abre las puertas.',
];

function pgFraseAleatoria() {
  return PG_FRASES[Math.floor(Math.random() * PG_FRASES.length)];
}

function cargarPagina(nombre) {
  const contenido = document.getElementById('contenido');
  if (!contenido) return;

  var fraseInicial = pgFraseAleatoria();
  contenido.innerHTML =
    '<div class="pg-loading">' +
      '<span class="pg-spinner"></span>' +
      '<p class="pg-frase" id="pg-frase-txt">' + fraseInicial + '</p>' +
      '<p class="pg-frase-sub">Un momento por favor&hellip;</p>' +
    '</div>';

  var fraseIdx = PG_FRASES.indexOf(fraseInicial);
  var fraseTimer = setInterval(function () {
    var el = document.getElementById('pg-frase-txt');
    if (!el) { clearInterval(fraseTimer); return; }
    el.style.opacity = '0';
    setTimeout(function () {
      var el2 = document.getElementById('pg-frase-txt');
      if (!el2) return;
      fraseIdx = (fraseIdx + 1) % PG_FRASES.length;
      el2.textContent = PG_FRASES[fraseIdx];
      el2.style.opacity = '1';
    }, 350);
  }, 2800);

  window.scrollTo({ top: 0, behavior: 'smooth' });

  fetchContenido(nombre)
    .then(html => {
      clearInterval(fraseTimer);
      contenido.innerHTML = html;
      // Registrar visita usando el hash actual de la URL
      var pageId = window.location.hash.replace('#', '') || 'inicio';
      registrarVisita(pageId);
      // Los scripts inyectados via innerHTML no se ejecutan; hay que recrearlos
      contenido.querySelectorAll('script').forEach(function (viejo) {
        var nuevo = document.createElement('script');
        Array.from(viejo.attributes).forEach(function (a) {
          nuevo.setAttribute(a.name, a.value);
        });
        nuevo.textContent = viejo.textContent;
        viejo.parentNode.replaceChild(nuevo, viejo);
      });
    })
    .catch(() => {
      clearInterval(fraseTimer);
      contenido.innerHTML = `
        <div class="pg-error inner">
          <p>No se pudo cargar el contenido.</p>
          <small>Las páginas estáticas no se encontraron.<br>
          Verifica que el proyecto esté completo en la carpeta <strong>Posgrado/pages/</strong>.</small>
        </div>`;
    });
}

function actualizarNavActivo(pageId) {
  const INACTIVO = '𐤏';
  const ACTIVO   = '⦿';
  document.querySelectorAll('[data-nav-section]').forEach(link => {
    const activo = link.dataset.navSection === pageId;
    link.classList.toggle('is-active', activo);
    link.setAttribute('aria-current', activo ? 'page' : 'false');
    const chevron = link.querySelector('.chevron');
    if (chevron) chevron.textContent = activo ? ACTIVO : INACTIVO;
  });
}

document.addEventListener('DOMContentLoaded', function () {
  // Clics en los enlaces del menú principal
  document.querySelectorAll('[data-nav-section]').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const pagina = this.dataset.navSection;
      history.pushState({ pagina }, '', '#' + pagina);
      cargarPagina(getPageFile(pagina));
      actualizarNavActivo(pagina);
    });
  });

  // Botón CTA de Contacto (no tiene data-nav-section)
  const ctaContacto = document.querySelector('.nav-cta');
  if (ctaContacto) {
    ctaContacto.addEventListener('click', function (e) {
      e.preventDefault();
      history.pushState({ pagina: 'contacto' }, '', '#contacto');
      cargarPagina(getPageFile('contacto'));
      actualizarNavActivo('contacto');
    });
  }

  // Pestañas internas — scoped a #contenido
  const contenido = document.getElementById('contenido');
  if (contenido) {
    contenido.addEventListener('click', function (e) {
      const tabBtn = e.target.closest('[data-tab]');
      if (!tabBtn) return;
      const tabName = tabBtn.dataset.tab;
      const wrapper = tabBtn.closest('[data-tabs]');
      if (wrapper) {
        wrapper.querySelectorAll('[data-tab]').forEach(b =>
          b.classList.toggle('activo', b.dataset.tab === tabName)
        );
        wrapper.querySelectorAll('[data-panel]').forEach(p => {
          p.hidden = p.dataset.panel !== tabName;
        });
      }
    });
  }

  // Navegación data-page — global: funciona en contenido dinámico Y en el footer
  document.addEventListener('click', function (e) {
    const enlace = e.target.closest('[data-page]');
    if (!enlace) return;
    e.preventDefault();
    const pagina = enlace.dataset.page;
    history.pushState({ pagina }, '', '#' + pagina);
    cargarPagina(getPageFile(pagina));
    actualizarNavActivo(pagina);
  });

  // Navegación del navegador (atrás / adelante)
  window.addEventListener('popstate', function (e) {
    const pagina = e.state?.pagina || 'inicio';
    cargarPagina(getPageFile(pagina));
    actualizarNavActivo(pagina);
  });

  // Página inicial según hash de la URL o inicio por defecto
  const hash = window.location.hash.replace('#', '');
  const paginaInicial = hash || 'inicio';
  cargarPagina(getPageFile(paginaInicial));
  actualizarNavActivo(paginaInicial);
});
