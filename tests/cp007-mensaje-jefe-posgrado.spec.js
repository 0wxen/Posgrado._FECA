const { test, expect } = require('@playwright/test');
const { SITE_URL } = require('./config');

test('CP-007: la sección Nosotros muestra el mensaje del Jefe de Posgrado', async ({ page }) => {
  await page.goto(SITE_URL);
  await page.click('[data-nav-section="nosotros"]');

  await expect(page.locator('#contenido h1')).toHaveText('Nosotros');

  const tarjetaJefe = page.locator('.mensaje-card', { hasText: 'Jefe de Posgrado' });
  await expect(tarjetaJefe).toBeVisible();
  await expect(tarjetaJefe).toContainText('Dr. Eliú J. Reyes Reyes');
});
