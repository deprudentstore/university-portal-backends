#!/bin/sh
set -e

# Fix: Create a placeholder .env file if it's missing
if [ ! -f /var/www/html/.env ]; then
    echo "Creating .env placeholder for Laravel..."
    touch /var/www/html/.env
fi

# Generate APP_KEY if it's not already set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

php artisan migrate --force
php artisan config:cache
php artisan route:cache

exec "$@"
exec "$@"
