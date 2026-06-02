# Build stage
FROM php:8.2-fpm-alpine as builder

RUN apk add --no-cache \
    git \
    curl \
    unzip

WORKDIR /app

# Installer dépendances système
RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy composer files
COPY composer.json composer.lock* ./

# Install PHP dependencies
RUN composer install --no-scripts --no-autoloader --prefer-dist

# Runtime stage
FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    git \
    postgresql-dev \
    nginx \
    supervisor \
    su-exec \
    curl \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql

WORKDIR /app

# Copy composer from builder
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Create necessary directories
RUN mkdir -p var/cache var/log \
    && chmod -R 777 var \
    && chown -R www-data:www-data /app

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf

# Copy supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Health check
HEALTHCHECK --interval=10s --timeout=5s --retries=5 \
  CMD curl -f http://localhost:8000/health || exit 1

# Start services
CMD ["sh", "-lc", "mkdir -p /app/var/cache /app/var/log && chown -R www-data:www-data /app/var && su-exec www-data php /app/bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration && exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf"]

EXPOSE 8000
