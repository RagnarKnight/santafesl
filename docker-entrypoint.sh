#!/bin/sh
# Entrypoint del contenedor "app". Corre como www-data.
set -e

# ── 3. Enlace público de storage ──────────────────────────────────
php artisan storage:link --force

# ── 6. Caches de producción ───────────────────────────────────────
php artisan config:cache --quiet
php artisan route:cache --quiet
php artisan view:cache --quiet

# ── 7. Proceso principal (php-fpm) ────────────────────────────────
exec "$@"
