# Estructura PHP + PostgreSQL

Esta carpeta contiene el backend dinámico del sitio.

## Entrada principal

El sitio público real es `Posgrado/html/htmlcode.html` (una sola página, navegación
por hash `#seccion` vía `Posgrado/js/cargar.js`). Ese JS pide el contenido de cada
sección directo a `pages/<nombre>.php` (por ejemplo `pages/home.php`) — cada archivo
en `pages/` es autocontenido (incluye `includes/content.php` por su cuenta), así que
no depende de ningún archivo "envoltorio" para funcionar.

`main.php` existió como una versión alterna server-rendered de todo el sitio, pero
nada lo enlazaba ni lo usaba — se eliminó.

## Base de datos

- `config/database.php`: conexión PostgreSQL con PDO. Lee credenciales de variables de
  entorno, o de `php/.env` si existe (no se sube a git).
- `database/schema.sql`: esquema completo del sitio (reemplaza cualquier versión anterior).
- `tools/install_db.php`: aplica `schema.sql`.
- `tools/test_connection.php`: página simple para comprobar que PHP conecta con PostgreSQL.
- `tools/cargar_env.ps1`: carga `php/.env` como variables de entorno en una sesión de PowerShell.

Variables de entorno: `PGHOST`, `PGPORT`, `PGDATABASE`, `PGUSER`, `PGPASSWORD`.

## Administración

- `admin/login.php`: acceso al panel (`admin/panel.php`).
- `admin/logout.php`: cierre de sesión, regresa al sitio público.
- `uploads/`: carpeta donde se guardan los archivos subidos desde el panel.

El primer usuario (rol `control_maestro`) se crea desde terminal, nunca desde el navegador:

```
php php/tools/setup_admin.php
```

## Panel de administración (`admin/panel.php`)

Deliberadamente simple: sin historial de cambios, sin páginas dinámicas ni bloques de
texto editables, sin cuerpos académicos propios (esos se enlazan a `cadepfeca.ujed.mx`).

**Roles** (tabla `usuarios`, columna `rol`):
- `control_maestro`: acceso a todas las pestañas, incluida "Usuarios" (crear/editar/eliminar
  cuentas del panel).
- `administrador`: acceso a las mismas pestañas de contenido, sin la pestaña "Usuarios".
- Un tercer rol de solo-edición queda pendiente para más adelante.

**Pestañas de contenido** (una tabla real por pestaña, ver `admin/modulos.php`):
Convocatorias, Nosotros · Profesores, Oferta Educativa, Investigación (Grupos
Disciplinares), Comunidad · Documentos, Blog/Noticias, Publicidad, Publicaciones.

**Pestaña "Imágenes del sitio":** reemplaza las imágenes fijas de la galería de Inicio
(5 espacios) y el Organigrama de Nosotros (tabla `imagenes_sitio`), sin crear/borrar filas.

**Pestaña "Estadísticas":** lee `localStorage` del navegador (visitas registradas por
`cargar.js` en el sitio público), no toca la base de datos.

**Formulario de contacto** (`pages/contact.php` → `tools/contacto_enviar.php`): envía el
mensaje por correo a Coordinación General con `mail()` de PHP. En XAMPP/Windows eso
requiere configurar un servidor SMTP en `php.ini` para entregar correos de verdad.

**Pendiente / fuera de alcance a propósito:**
- Las páginas legales y de trámites (`terms`, `privacy_notice`, `titulacion`,
  `procesos_academicos`, `unidades_aprendizaje`) tienen contenido fijo escrito directo en su
  `.php` (en `pages/`) -- sin tabla propia ni panel de edición.
- No hay historial/auditoría de cambios ni forma de deshacer una edición o borrado.
