# docker/php/Dockerfile
FROM php:8.1-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/html/

# Установим необходимые расширения
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Проверьте установку Composer
RUN composer --version
