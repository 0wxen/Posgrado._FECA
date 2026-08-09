const { test, expect } = require('@playwright/test');
const { SITE_URL } = require('./config');

const REDES = [
  { etiqueta: 'Facebook', href: 'https://www.facebook.com/FECAUJEDMX' },
  { etiqueta: 'X / Twitter', href: 'https://x.com/fecaujedmx' },
  { etiqueta: 'Instagram', href: 'https://www.instagram.com/fecaujedmx' },
  { etiqueta: 'TikTok', href: 'https://www.tiktok.com/@fecaujed.mx' },
];

test('CP-010: los íconos de redes sociales enlazan a las cuentas oficiales', async ({ page }) => {
  await page.goto(SITE_URL);

  for (const red of REDES) {
    const enlace = page.locator(`.top-bar a[aria-label="${red.etiqueta}"]`);
    await expect(enlace).toHaveAttribute('href', red.href);
    await expect(enlace).toHaveAttribute('target', '_blank');
  }

  const correo = page.locator('.top-bar a[aria-label="Correo electrónico"]');
  await expect(correo).toHaveAttribute('href', 'mailto:posgradofeca@ujed.mx');
});
