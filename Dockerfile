FROM php:8.3-fpm

# Установка системных пакетов и PHP-расширений
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка прав для работы с файлами
WORKDIR /var/www/html/public


# Устанавливаем пользователя www-data (по умолчанию в PHP-FPM)
RUN chown -R www-data:www-data /var/www/html