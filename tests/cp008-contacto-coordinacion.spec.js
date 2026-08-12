const { test, expect } = require('@playwright/test');
const { irASitio } = require('./helpers/sitio');

test('CP-008: el formulario de contacto todavía no guarda el mensaje (pendiente)', async ({ page }) => {
  await irASitio(page, 'contacto');
  await expect(page.locator('#contenido h1')).toHaveText('Contacto');

  await page.fill('#c-nombre', 'Estudiante de Prueba');
  await page.fill('#c-email', 'prueba@ujed.mx');
  await page.selectOption('#c-asunto', 'informacion');
  await page.fill('#c-mensaje', 'Mensaje de prueba generado por Playwright.');
  await page.click('button.btn-submit');

  await expect(page).toHaveURL(/error=servidor/);
});
