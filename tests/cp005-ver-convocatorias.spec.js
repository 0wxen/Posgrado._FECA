const { test, expect } = require('@playwright/test');
const { irASitio } = require('./helpers/sitio');

test('CP-005: el botón "Ver Convocatorias" del inicio lleva a la sección de Convocatorias', async ({ page }) => {
  await irASitio(page);

  await expect(page.locator('.hero-split-title, .hero-split-desc').first()).toBeVisible();
  await page.getByRole('link', { name: 'Ver Convocatorias' }).click();

  await expect(page).toHaveURL(/#convocatorias$/);
  await expect(page.locator('#contenido h1')).toHaveText('Convocatorias');
});
