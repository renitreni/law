#!/bin/bash
set -e

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Clear config to pick up new key
php artisan config:clear

# Run composer post-install scripts (package discovery, etc.)
php artisan package:discover --ansi

# Create storage link
php artisan storage:link --force

# Wait for database to be ready (retry up to 30 times with 2s intervals)
echo "Waiting for database connection..."
for i in {1..30}; do
    if php artisan migrate --force 2>/dev/null; then
        echo "Database migration completed."
        break
    fi
    echo "Database not ready, waiting... ($i/30)"
    sleep 2
done

# Publish Livewire assets (fixes "assets out of date" warning)
php artisan vendor:publish --tag=livewire:assets --force

# Cache config, routes, views outside local development
if [ "${APP_ENV:-}" != "local" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Fix permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Start Nginx in background
nginx

# Start PHP-FPM
exec php-fpm