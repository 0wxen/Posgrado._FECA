const { test, expect } = require('@playwright/test');
const { ADMIN_USER, ADMIN_PASSWORD } = require('./config');
const { irASitio } = require('./helpers/sitio');

test('CP-002: un administrador inicia sesión desde el modal del sitio y entra al panel', async ({ page }) => {
  await irASitio(page);
  await page.click('#btn-abrir-login');

  const modal = page.locator('#modal-login');
  await expect(modal).toBeVisible();
  await expect(modal.getByText('Acceso al Portal')).toBeVisible();

  await modal.locator('#login-usuario').fill(ADMIN_USER);
  await modal.locator('#login-pass').fill(ADMIN_PASSWORD);
  await modal.getByRole('button', { name: 'Iniciar Sesión' }).click();

  await expect(page).toHaveURL(/panel\.php/);
  await expect(page.locator('.panel-header-title')).toContainText('Panel de Administración');
});
