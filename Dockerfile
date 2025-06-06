# PHP base image với Apache
FROM php:8.1-apache

# Cài các thư viện cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip unzip curl git \
    && docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Bật module rewrite của Apache
RUN a2enmod rewrite

# Copy Composer từ official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy toàn bộ mã nguồn Laravel vào container
COPY . /var/www

# Đặt thư mục làm việc mặc định
WORKDIR /var/www

# Cài đặt Composer dependencies
RUN composer install --optimize-autoloader --no-dev

# Tạo thư mục runtime và phân quyền
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Copy thư mục public vào đúng vị trí Apache phục vụ
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html

# Tạo APP_KEY và cache config
RUN cp .env.docker .env && \
    php artisan key:generate && \
    php artisan config:cache && \
    php artisan route:cache

# Expose cổng 80
EXPOSE 80
