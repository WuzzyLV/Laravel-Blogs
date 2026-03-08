#!/bin/sh
set -e

cd /var/www/html

# Generate app key if not already set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Ensure the SQLite database file exists
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    touch database/database.sqlite
    chown www-data:www-data database/database.sqlite
fi

# Run migrations
php artisan migrate --force

# Create storage symlink (idempotent)
php artisan storage:link --force 2>/dev/null || true

# Clear & warm caches for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
