// Backend PHP+Postgres real (PosgradoReact/backend/php), no un mock.
// En desarrollo corre con `php -S 127.0.0.1:8001 tools/router.php`
// (igual que antes en Posgrado/js/cargar.js). Para producción, definir
// VITE_API_BASE apuntando al host donde se sirva ese PHP.
export const API_BASE = import.meta.env.VITE_API_BASE || 'http://127.0.0.1:8001';

// Rutas ya existentes en el backend (ver backend/php/api/v1/index.php),
// que sí devuelve JSON y ya trae CORS abierto.
export const API_V1 = `${API_BASE}/php/api/v1/index.php`;

// admin/login.php sigue siendo un POST de formulario clásico con sesión
// por cookie (no un endpoint JSON) -- se mantiene así a propósito, ver
// PosgradoReact/backend/php/config/auth.php.
export const ADMIN_LOGIN_URL = `${API_BASE}/php/admin/login.php`;
