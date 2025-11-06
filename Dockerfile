# Gunakan PHP 8.2 dengan Apache
FROM php:8.2-apache

# Install ekstensi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file Laravel ke dalam container
COPY . .

# Install dependencies Laravel (jangan jalan kalau vendor udah ada)
RUN composer install --no-dev --optimize-autoloader || true

# Set permission untuk storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Aktifkan mod_rewrite agar route Laravel bisa berfungsi
RUN a2enmod rewrite

# Tambahkan konfigurasi Apache untuk Laravel
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Expose port 80 (port Apache default)
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
