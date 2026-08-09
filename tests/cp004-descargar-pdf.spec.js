const path = require('node:path');
const { test, expect } = require('@playwright/test');
const { ADMIN_PANEL_URL, PUBLIC_SITE_URL } = require('./config');
const { loginComoAdmin } = require('./helpers/auth');

test('CP-004: se puede descargar el PDF de una convocatoria publicada', async ({ page }) => {
  const titulo = `Convocatoria con PDF ${Date.now()}`;

  await loginComoAdmin(page);
  await page.goto(`${ADMIN_PANEL_URL}?tab=convocatorias&nuevo=1#formulario`);
  await page.fill('#f-titulo', titulo);
  await page.setInputFiles('input[name="archivo_id"]', path.join(__dirname, 'fixtures', 'dummy.pdf'));
  await page.check('#f-es_publicado');
  await page.click('button.btn-primary');
  await expect(page.locator('.panel-flash--ok')).toBeVisible();

  await page.goto(PUBLIC_SITE_URL.replace('page=inicio', 'page=convocatorias'));
  const enlaceDescarga = page
    .locator('.noticia-card', { hasText: titulo })
    .getByRole('link', { name: 'Descargar' });

  await expect(enlaceDescarga).toBeVisible();
  const href = await enlaceDescarga.getAttribute('href');
  expect(href).toMatch(/uploads\/.+\.pdf$/);

  const respuesta = await page.request.get(new URL(href, page.url()).toString());
  expect(respuesta.status()).toBe(200);
  expect(respuesta.headers()['content-type']).toContain('pdf');
});
