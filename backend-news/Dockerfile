# Use the official PHP image with Apache
FROM php:8.2-apache

# Install required extensions and dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip

# Set the working directory
WORKDIR /var/www/html

# Enable Apache rewrite module
RUN a2enmod rewrite
RUN a2enmod headers

# Copy application source
COPY . /var/www/html

# Copy Apache configuration
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Restart Apache
RUN service apache2 restart

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Run Composer install
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
