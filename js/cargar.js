const PAGES_PATH = '/php/pages/';

function cargarPagina(nombre) {
  const contenido = document.getElementById('contenido');
  if (!contenido) return;

  contenido.innerHTML = '<div class="pg-loading"><span class="pg-spinner"></span></div>';
  window.scrollTo({ top: 0, behavior: 'smooth' });

  fetch(PAGES_PATH + nombre)
    .then(r => {
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.text();
    })
    .then(html => {
      contenido.innerHTML = html;
      const pageId = nombre.replace('.php', '');
      actualizarNavActivo(pageId);
    })
    .catch(() => {
      contenido.innerHTML = `
        <div class="pg-error inner">
          <p>No se pudo cargar el contenido.</p>
          <small>Asegúrate de que el servidor PHP esté activo en <strong>http://127.0.0.1:8001</strong></small>
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
      cargarPagina(pagina + '.php');
    });
  });

  // Botón CTA de Contacto (no tiene data-nav-section)
  const ctaContacto = document.querySelector('.nav-cta');
  if (ctaContacto) {
    ctaContacto.addEventListener('click', function (e) {
      e.preventDefault();
      history.pushState({ pagina: 'contacto' }, '', '#contacto');
      cargarPagina('contacto.php');
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
    cargarPagina(pagina + '.php');
    actualizarNavActivo(pagina);
  });

  // Navegación del navegador (atrás / adelante)
  window.addEventListener('popstate', function (e) {
    const pagina = e.state?.pagina || 'inicio';
    cargarPagina(pagina + '.php');
    actualizarNavActivo(pagina);
  });

  // Página inicial según hash de la URL o inicio por defecto
  const hash = window.location.hash.replace('#', '');
  const paginaInicial = hash || 'inicio';
  cargarPagina(paginaInicial + '.php');
  actualizarNavActivo(paginaInicial);
});
