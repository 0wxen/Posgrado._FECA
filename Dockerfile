FROM php:8.2-cli

# pdo_pgsql y mbstring necesitan estas librerías del sistema para compilar
# (php:8.2-cli no las trae por defecto).
RUN apt-get update && apt-get install -y --no-install-recommends \
      libpq-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY Posgrado/ /app/

# Render inyecta $PORT en tiempo de ejecución; el servidor embebido de PHP
# sirve estático (html/, assets/) y dinámico (php/) desde la misma raíz,
# igual que start_php_server.bat en local.
CMD php -S 0.0.0.0:${PORT:-10000} -t . php/tools/router.php
