# Estructura PHP + PostgreSQL

Esta carpeta contiene la base del sitio dinámico.

## Entrada principal

- `principal.php`: conserva encabezado, navegación y pie de página.
- `pages/`: contiene el contenido central de cada sección.

Ejemplos:

- `principal.php?page=inicio`
- `principal.php?page=nosotros`
- `principal.php?page=blog`

Si no se manda `page`, se carga `inicio`.

## Base de datos

- `config/database.php`: conexión PostgreSQL con PDO.
- `conexion.php`: compatibilidad con archivos existentes que usan `$conexion`.
- `tools/probar_conexion.php`: página simple para comprobar que PHP conecta con PostgreSQL.
- `tools/iniciar_servidor_php.bat`: inicia el servidor local con XAMPP PHP.
- `database/schema.sql`: tablas iniciales para contenidos cargados desde el panel.

Variables de entorno recomendadas:

- `PGHOST`
- `PGPORT`
- `PGDATABASE`
- `PGUSER`
- `PGPASSWORD`

En desarrollo se integró la configuración local recibida:

- Base de datos: `posgrado_Feca`
- Usuario: `postgres`
- Puerto: `5432`

La contraseña puede cambiarse después con `PGPASSWORD`.

## Administración

- `admin/login.php`: acceso al panel.
- `admin/index.php`: apartado privado para futuras cargas.
- `admin/logout.php`: cierre de sesión.
- `uploads/`: carpeta preparada para archivos que se suban después.

Credenciales temporales de desarrollo:

- Usuario: `admin`
- Contraseña: `cambiar-esta-clave`

Antes de publicar, cambia esas credenciales con variables de entorno:

- `ADMIN_USER`
- `ADMIN_PASSWORD`

## Imágenes actuales

La carpeta descargada de `División de Estudios...` no se movió. El sitio puede seguir usando imágenes desde ahí mientras se decide la estructura final de assets.
