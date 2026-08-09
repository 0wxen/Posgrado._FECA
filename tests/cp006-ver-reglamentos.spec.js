const path = require('node:path');
const { test, expect } = require('@playwright/test');
const { ADMIN_PANEL_URL, PUBLIC_SITE_URL } = require('./config');
const { loginComoAdmin } = require('./helpers/auth');

test('CP-006: un documento/reglamento publicado se puede descargar desde Transparencia', async ({ page }) => {
  const titulo = `Reglamento de prueba ${Date.now()}`;

  await loginComoAdmin(page);
  await page.goto(`${ADMIN_PANEL_URL}?tab=documentos&nuevo=1#formulario`);
  await page.fill('#f-titulo', titulo);
  await page.selectOption('#f-categoria', 'reglamento');
  await page.selectOption('#f-audiencia', 'alumnado');
  await page.setInputFiles('input[name="archivo_id"]', path.join(__dirname, 'fixtures', 'dummy.pdf'));
  await page.check('#f-es_publicado');
  await page.click('button.btn-primary');
  await expect(page.locator('.panel-flash--ok')).toBeVisible();

  await page.goto(PUBLIC_SITE_URL.replace('page=inicio', 'page=transparencia'));
  const enlace = page.getByRole('link', { name: titulo });
  await expect(enlace).toBeVisible();

  const href = await enlace.getAttribute('href');
  const respuesta = await page.request.get(new URL(href, page.url()).toString());
  expect(respuesta.status()).toBe(200);
  expect(respuesta.headers()['content-type']).toContain('pdf');
});
