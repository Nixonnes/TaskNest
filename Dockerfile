FROM php:8.3-fpm

# Установка системных пакетов и PHP-расширений
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql

ENV PHP_IDE_CONFIG "serverName=docker"
    # Устанавливаем Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Копируем файл конфигурации Xdebug
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions xdebug
ENV PHP_IDE_CONFIG 'serverName=docker'
COPY xdebug.ini /usr/local/etc/php/conf.d/

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка прав для работы с файлами
WORKDIR /var/www/html/public


# Устанавливаем пользователя www-data (по умолчанию в PHP-FPM)
RUN chown -R www-data:www-data /var/www/html