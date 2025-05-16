FROM php:8.3-fpm

# Instala extensões necessárias
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    mariadb-client libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Permissões
RUN chown -R www-data:www-data /var/www

# PHP config (opcional)
COPY . /var/www
