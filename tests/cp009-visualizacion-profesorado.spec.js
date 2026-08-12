const { test, expect } = require('@playwright/test');
const { irASitio } = require('./helpers/sitio');

test('CP-009: la pestaña Profesorado de Comunidad muestra sus recursos', async ({ page }) => {
  await irASitio(page);
  await page.click('[data-nav-section="comunidad"]');
  await expect(page.locator('#contenido h1')).toHaveText('Comunidad');

  await page.click('[data-tab="profesorado"]');
  const panelProfesorado = page.locator('[data-panel="profesorado"]');
  await expect(panelProfesorado).toBeVisible();
  await expect(panelProfesorado.locator('h2', { hasText: 'Recursos para Profesorado' })).toBeVisible();
  await expect(panelProfesorado.locator('.recurso-card').first()).toBeVisible();
});
