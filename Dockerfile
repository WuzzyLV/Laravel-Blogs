# ============================================================
# Stage 0 — Composer: install vendor deps (needed for Flux CSS)
# ============================================================
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# ============================================================
# Stage 1 — Node: compile frontend assets
# ============================================================
FROM node:22-alpine AS assets

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY --from=composer /app/vendor vendor/

COPY resources/ resources/
COPY vite.config.js ./
COPY public/ public/

RUN npm run build

# ============================================================
# Stage 2 — PHP-FPM: application
# ============================================================
FROM php:8.3-fpm-alpine AS app

# Install system dependencies + PHP extensions
RUN apk add --no-cache \
        nginx \
        supervisor \
        curl \
        unzip \
        sqlite-dev \
    && docker-php-ext-install \
        pdo_sqlite \
        bcmath \
        pcntl \
    && docker-php-ext-enable opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy the rest of the application
COPY . .

# Copy compiled assets from Stage 1
COPY --from=assets /app/public/build public/build

# Finish composer (dump autoload, run scripts)
RUN composer dump-autoload --optimize --no-dev

# Copy config files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh \
    && mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
