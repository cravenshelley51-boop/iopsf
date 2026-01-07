# Stage 1 - Build Frontend (Vite)
FROM node:18 AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
# Build assets for production
RUN npm run build
# Verify build output
RUN ls -la public/build/ || echo "Build directory check"

# Stage 2 - Backend (Laravel + PHP + Composer)
FROM php:8.2-fpm AS backend

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    zip \
    nginx \
    supervisor \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libsqlite3-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_sqlite \
    mbstring \
    zip \
    opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .

# Copy built frontend from Stage 1 (Laravel Vite outputs to public/build)
# Copy the entire public/build directory structure including .vite subdirectory and manifest
COPY --from=frontend --chown=www-data:www-data /app/public/build ./public/build

# Verify build assets were copied correctly
RUN ls -la public/build/ 2>/dev/null && \
    (test -f public/build/.vite/manifest.json || test -f public/build/manifest.json || echo "Warning: Vite manifest not found") || \
    echo "Warning: public/build directory may be empty"

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel setup
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

# Create necessary directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    bootstrap/cache \
    database \
    /var/log/supervisor \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

# Copy nginx configuration
RUN rm -f /etc/nginx/sites-enabled/default
COPY docker/nginx.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Copy supervisor configuration
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    echo "upload_max_filesize = 10M" >> "$PHP_INI_DIR/php.ini" && \
    echo "post_max_size = 10M" >> "$PHP_INI_DIR/php.ini" && \
    echo "memory_limit = 256M" >> "$PHP_INI_DIR/php.ini"

# Expose port 80
EXPOSE 80

# Use supervisor to manage nginx and php-fpm
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

