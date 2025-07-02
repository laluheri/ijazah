FROM php:8.2-apache

# Install extensions
RUN apt-get update && apt-get install -y \
    zip unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project
WORKDIR /var/www/html
COPY . .

# Set permission
RUN chmod -R 775 storage bootstrap/cache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Apache config
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
</Directory>" >> /etc/apache2/apache2.conf

# Expose port
EXPOSE 8080

# Run server
CMD ["apache2-foreground"]
