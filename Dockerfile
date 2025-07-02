# Base image PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    zip unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev git \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja di dalam container
WORKDIR /var/www/html

# Copy seluruh isi proyek Laravel ke dalam container
COPY . .

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Set izin folder storage & cache Laravel
RUN chmod -R 775 storage bootstrap/cache

# Aktifkan mod_rewrite Apache (penting untuk routing Laravel)
RUN a2enmod rewrite

# Konfigurasi Apache agar mengenali folder public Laravel
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/apache2.conf

# Hilangkan warning Apache: "Could not reliably determine server name"
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port Railway (Railway mendengarkan di 8080)
EXPOSE 8080

# Jalankan Apache (default command saat container dimulai)
CMD ["apache2-foreground"]
