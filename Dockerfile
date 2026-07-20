FROM php:8.2-fpm-alpine

RUN apk add --no-cache git unzip libpq-dev icu-dev \
    && docker-php-ext-install pdo pdo_mysql intl opcache

# Copy PHP configuration
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Create opcache cache directory
RUN mkdir -p /tmp/opcache && chmod 777 /tmp/opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html