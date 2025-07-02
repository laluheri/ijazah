FROM php:8.2-cli

# Install PHP dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev unzip zip git curl libpng-dev \
    libonig-dev libxml2-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel permission
RUN chmod -R 755 storage bootstrap/cache

# Laravel entrypoint (pakai php server)
CMD php artisan serve --host=0.0.0.0 --port=8080
