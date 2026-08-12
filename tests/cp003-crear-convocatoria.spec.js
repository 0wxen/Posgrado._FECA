const { test, expect } = require('@playwright/test');
const { ADMIN_PANEL_URL } = require('./config');
const { loginComoAdmin } = require('./helpers/auth');

test('CP-003: un administrador puede crear una convocatoria nueva', async ({ page }) => {
  const titulo = `Convocatoria de prueba ${Date.now()}`;

  await loginComoAdmin(page);
  await page.goto(`${ADMIN_PANEL_URL}?tab=convocatorias&nuevo=1#formulario`);

  await page.fill('#f-titulo', titulo);
  await page.fill('#f-ciclo', 'B-2026');
  await page.fill('#f-descripcion', 'Convocatoria generada automáticamente por Playwright.');
  await page.check('#f-es_publicado');
  page.once('dialog', dialog => dialog.accept());
  await page.click('button.btn-primary');

  await expect(page).toHaveURL(/tab=convocatorias/);
  await expect(page.locator('.panel-flash--ok')).toBeVisible();
  await expect(page.locator('.admin-card-title', { hasText: titulo })).toBeVisible();
});
