#!/bin/sh
set -e

# Wait for database to be ready (if using external database)
# Uncomment and modify if needed:
# while ! nc -z $DB_HOST $DB_PORT; do
#   echo "Waiting for database..."
#   sleep 1
# done

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations (only if AUTO_MIGRATE is set to true)
if [ "$AUTO_MIGRATE" = "true" ]; then
    php artisan migrate --force
fi

# Clear and cache configuration
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Execute the main command
exec "$@"

