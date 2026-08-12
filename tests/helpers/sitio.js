const { SITE_URL } = require('../config');

// El modal de privacidad de primera visita (localStorage dep_privacidad_v1) tapa
// toda la página en un contexto de navegador limpio como el de Playwright -- lo
// pre-aceptamos antes de navegar para que los clics no queden bloqueados por él.
async function irASitio(page, hash) {
  await page.addInitScript(() => localStorage.setItem('dep_privacidad_v1', '1'));
  await page.goto(hash ? `${SITE_URL}#${hash}` : SITE_URL);
}

module.exports = { irASitio };
