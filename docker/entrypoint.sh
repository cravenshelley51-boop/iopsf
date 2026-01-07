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

# Ensure database directory exists and is writable
mkdir -p database
chown -R www-data:www-data database
chmod -R 775 database

# Create SQLite database file if it doesn't exist
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    chown www-data:www-data database/database.sqlite
    chmod 664 database/database.sqlite
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
php artisan view:cache

# Cache routes (skip if it fails to avoid breaking deployment)
php artisan route:cache || echo "Warning: Route caching failed, continuing without route cache..."

# Set proper permissions
chown -R www-data:www-data storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache database

# Ensure database file permissions are correct
if [ -f database/database.sqlite ]; then
    chown www-data:www-data database/database.sqlite
    chmod 664 database/database.sqlite
fi

# Execute the main command
exec "$@"

