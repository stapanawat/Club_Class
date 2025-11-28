FROM php:8.3-fpm

# ---- PHP Exts ----
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring gd exif pcntl bcmath

# ---- Composer ----
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# เอาโค้ดเข้า image (สำหรับรัน artisan, composer ฯลฯ)
COPY . /var/www/html

# ติดตั้ง PHP dependencies
RUN composer install

CMD ["php-fpm"]
