#!/bin/sh
# Entrypoint del contenedor "app". Corre como www-data.
set -e

# ── 1. Configuración mínima obligatoria ───────────────────────────
if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: falta APP_KEY. Completala en .env.production (ver .env.production.example)." >&2
    exit 1
fi

if [ "${APP_ENV:-production}" = "production" ] && [ "${APP_DEBUG:-false}" = "true" ]; then
    echo "ERROR: APP_DEBUG=true con APP_ENV=production. Poné APP_DEBUG=false." >&2
    exit 1
fi

# ── 3. Enlace público de storage ──────────────────────────────────
php artisan storage:link --force

# ── 6. Caches de producción ───────────────────────────────────────
php artisan config:cache --quiet
php artisan route:cache --quiet
php artisan view:cache --quiet

# ── 7. Proceso principal (php-fpm) ────────────────────────────────
exec "$@"
