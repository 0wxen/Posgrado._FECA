const { ADMIN_LOGIN_URL, ADMIN_USER, ADMIN_PASSWORD } = require('../config');

/** Inicia sesión en el panel de administración y deja la página ya en panel.php. */
async function loginComoAdmin(page, usuario = ADMIN_USER, password = ADMIN_PASSWORD) {
  await page.goto(ADMIN_LOGIN_URL);
  await page.fill('#usuario', usuario);
  await page.fill('#password', password);
  await page.click('button.btn-login');
  await page.waitForURL(/panel\.php/);
}

module.exports = { loginComoAdmin };
