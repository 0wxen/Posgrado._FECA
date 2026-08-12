const { test, expect } = require('@playwright/test');
const { irASitio } = require('./helpers/sitio');

test('CP-001: el botón SUMA+ enlaza al control escolar en pestaña nueva', async ({ page }) => {
  await irASitio(page);

  const enlaceSuma = page.locator('a.topbar-suma-link');
  await expect(enlaceSuma).toBeVisible();
  await expect(enlaceSuma).toHaveAttribute('href', 'https://sumafeca.ujed.mx/');
  await expect(enlaceSuma).toHaveAttribute('target', '_blank');
});
