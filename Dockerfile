# =============================================================================
# Proyecto - Dockerfile
# =============================================================================
# Los datos persistentes serán proporcionados por Docker Compose:
#
# =============================================================================

# =============================================================================
# STAGE 1 — Node / Vite
# =============================================================================
FROM node:22.23.4-slim AS node-builder

WORKDIR /app

COPY package.json package-lock.json* ./

RUN npm ci --no-audit --no-fund

COPY . .

# public/storage puede venir como symlink del entorno de desarrollo: no va a la imagen.
RUN npm run build && rm -f public/storage


# =============================================================================
# STAGE 2 — PHP / Composer
# =============================================================================

FROM php:8.4.27-fpm-alpine3.23 AS builder-fpm

WORKDIR /app

RUN apk add --no-cache \
        libpq-dev \
        libzip-dev \
        oniguruma-dev \
        libxml2-dev \
        sqlite \
        sqlite-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        gd \
        mbstring \
        xml \
        zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock* ./

RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader


# =============================================================================
# STAGE 3 — PHP-FPM Runtime
# =============================================================================

FROM php:8.4.27-fpm-alpine3.23

WORKDIR /var/www/html


# -----------------------------------------------------------------------------
# Dependencias PHP
# -----------------------------------------------------------------------------

RUN apk add --no-cache \
        libpq \
        libzip \
        oniguruma \
        libxml2 \
        sqlite \
        sqlite-dev \
        freetype \
        libjpeg-turbo \
        libpng \
    && apk add --no-cache --virtual .build-deps \
        libpq-dev \
        libzip-dev \
        oniguruma-dev \
        libxml2-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        gd \
        mbstring \
        opcache \
        xml \
        zip \
    && apk del .build-deps

# Ajustes de PHP para producción (opcache, sin errores en pantalla, límites).
COPY docker/php/production.ini /usr/local/etc/php/conf.d/zz-production.ini

COPY --chown=www-data:www-data . .

RUN rm -f bootstrap/cache/packages.php bootstrap/cache/services.php

COPY --from=builder-fpm --chown=www-data:www-data /app/vendor ./vendor

COPY --from=node-builder --chown=www-data:www-data /app/public ./public

# Entrypoint: se copia ANTES de cualquier chmod sobre él.
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod 755 /usr/local/bin/docker-entrypoint.sh

# Directorios que Laravel necesita. database/.sqlite-data es el punto de
# montaje del volumen de SQLite (NO se monta sobre database/).
RUN mkdir -p \
        bootstrap/cache \
        database/.sqlite-data \
        storage/framework/views \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/testing \
        storage/logs \
        storage/app/public \
        storage/app/private \
        storage/app/backups \
    && chown -R www-data:www-data storage bootstrap/cache  \
    && chmod -R 775 storage bootstrap/cache

USER www-data

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["php-fpm"]
