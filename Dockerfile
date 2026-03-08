# ============================================================
# Stage 1 — Composer: vendor deps (needed for Flux CSS in Vite)
# ============================================================
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# ============================================================
# Stage 2 — Node: compile frontend assets
# ============================================================
FROM node:22-alpine AS assets

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY --from=vendor /app/vendor vendor/
COPY resources/ resources/
COPY vite.config.js ./
COPY public/ public/

RUN npm run build

# ============================================================
# Stage 2 — PHP: application (Ubuntu + ondrej/php PPA)
# ============================================================
FROM ubuntu:24.04 AS app

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Add ondrej/php PPA and install PHP 8.4 + required extensions + Nginx + Supervisor
RUN apt-get update \
    && apt-get install -y gnupg curl ca-certificates unzip sqlite3 nginx supervisor \
    && mkdir -p /etc/apt/keyrings \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xb8dc7e53946656efbce4c1dd71daeaab4ad4cab6' \
       | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu noble main" \
       > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y \
       php8.4-fpm \
       php8.4-cli \
       php8.4-sqlite3 \
       php8.4-mbstring \
       php8.4-xml \
       php8.4-zip \
       php8.4-bcmath \
       php8.4-curl \
       php8.4-intl \
       php8.4-opcache \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies
COPY composer.json composer.lock ./
RUN mkdir -p bootstrap/cache \
    && composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application
COPY . .

# Copy compiled assets from Stage 1
COPY --from=assets /app/public/build public/build

# Finalise composer
RUN composer dump-autoload --optimize --no-dev

# Copy config files
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh \
    && mkdir -p storage/logs \
                storage/framework/cache \
                storage/framework/sessions \
                storage/framework/views \
                bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
