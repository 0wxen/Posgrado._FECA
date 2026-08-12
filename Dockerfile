FROM php:8.2-cli

RUN docker-php-ext-install pdo pdo_pgsql mbstring

WORKDIR /app
COPY Posgrado/ /app/

# Render inyecta $PORT en tiempo de ejecución; el servidor embebido de PHP
# sirve estático (html/, assets/) y dinámico (php/) desde la misma raíz,
# igual que start_php_server.bat en local.
CMD php -S 0.0.0.0:${PORT:-10000} -t . php/tools/router.php
