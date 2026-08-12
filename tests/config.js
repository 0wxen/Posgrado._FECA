// Ajusta SITE_URL según cómo abras htmlcode.html con Live Server en tu VS Code.
// Ejemplo si Live Server sirve desde la raíz del repo (clic derecho en htmlcode.html > "Open with Live Server"):
//   http://127.0.0.1:5500/Posgrado/html/htmlcode.html
const SITE_URL = process.env.SITE_URL || 'http://127.0.0.1:5500/Posgrado/html/htmlcode.html';

// El sitio PHP corre con Posgrado/php/tools/start_php_server.bat (déjalo abierto mientras corres las pruebas).
const PHP_BASE = process.env.PHP_BASE || 'http://127.0.0.1:8001';
const ADMIN_LOGIN_URL = `${PHP_BASE}/php/admin/login.php`;
const ADMIN_PANEL_URL = `${PHP_BASE}/php/admin/panel.php`;

// Cuenta creada con tools/setup_admin.php -- cámbiala aquí o con variables de entorno
// (ADMIN_USER / ADMIN_PASSWORD) si usas otra cuenta.
const ADMIN_USER = process.env.ADMIN_USER || 'program';
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD || 'MirandaOwenJose';

module.exports = {
  SITE_URL,
  PHP_BASE,
  ADMIN_LOGIN_URL,
  ADMIN_PANEL_URL,
  ADMIN_USER,
  ADMIN_PASSWORD,
};
