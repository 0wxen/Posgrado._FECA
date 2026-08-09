const { test, expect } = require('@playwright/test');
const { SITE_URL, ADMIN_LOGIN_URL, ADMIN_USER, ADMIN_PASSWORD } = require('./config');

test('CP-002a: el botón Ingresar abre el modal con la opción Control Maestro', async ({ page }) => {
  await page.goto(SITE_URL);
  await page.click('#btn-abrir-login');

  const modal = page.locator('#modal-login');
  await expect(modal).toBeVisible();
  await expect(modal.getByText('Control Maestro')).toBeVisible();
});

test('CP-002b: un administrador puede iniciar sesión con usuario y contraseña válidos', async ({ page }) => {
  await page.goto(ADMIN_LOGIN_URL);
  await page.fill('#usuario', ADMIN_USER);
  await page.fill('#password', ADMIN_PASSWORD);
  await page.click('button.btn-login');

  await expect(page).toHaveURL(/panel\.php/);
  await expect(page.locator('.panel-header-title')).toContainText('Panel de Administración');
});

test('CP-002c: con credenciales inválidas no se puede iniciar sesión', async ({ page }) => {
  await page.goto(ADMIN_LOGIN_URL);
  await page.fill('#usuario', 'usuario_que_no_existe');
  await page.fill('#password', 'contraseña_incorrecta');
  await page.click('button.btn-login');

  await expect(page).toHaveURL(/login\.php/);
  await expect(page.locator('.error-msg')).toContainText('incorrectos');
});
