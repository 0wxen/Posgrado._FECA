const { test, expect } = require('@playwright/test');
const { PUBLIC_SITE_URL } = require('./config');

test('CP-008: el formulario de contacto todavía no guarda el mensaje (pendiente)', async ({ page }) => {
  await page.goto(PUBLIC_SITE_URL.replace('page=inicio', 'page=contacto'));

  await page.fill('#c-nombre', 'Estudiante de Prueba');
  await page.fill('#c-email', 'prueba@ujed.mx');
  await page.selectOption('#c-asunto', 'informacion');
  await page.fill('#c-mensaje', 'Mensaje de prueba generado por Playwright.');
  await page.click('button.btn-submit');

  await expect(page).toHaveURL(/error=servidor/);
});
