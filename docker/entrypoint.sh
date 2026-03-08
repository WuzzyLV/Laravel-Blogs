#!/bin/bash
set -e

cd /var/www/html

# Create .env from example if it doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Write environment variables into .env
sed -i "s|^APP_NAME=.*|APP_NAME=${APP_NAME:-Laravel}|" .env
sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV:-production}|" .env
sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG:-false}|" .env
sed -i "s|^APP_URL=.*|APP_URL=${APP_URL:-http://localhost}|" .env
sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION:-sqlite}|" .env
sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=${SESSION_DRIVER:-database}|" .env
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=${CACHE_STORE:-database}|" .env
sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=${QUEUE_CONNECTION:-database}|" .env

# Ensure php-fpm socket directory exists
mkdir -p /run/php

# Ensure the SQLite database file exists
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    touch database/database.sqlite
    chown www-data:www-data database/database.sqlite
fi

# Clear any stale config cache from build stage
php artisan config:clear
php artisan cache:clear

# Run migrations
php artisan migrate --force

# Create storage symlink (idempotent)
php artisan storage:link --force 2>/dev/null || true

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
