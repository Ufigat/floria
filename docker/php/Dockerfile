FROM php:8.1-fpm

# Установка зависимостей для Symfony CLI и PHP расширений
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    libpq-dev \
    git \
    libssl-dev \
    zlib1g-dev \
    libcurl4-openssl-dev \
    && apt-get install -y libpcntl-dev || echo "libpcntl-dev not available" \
    && rm -rf /var/lib/apt/lists/*

# Установка расширений PHP
RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install pcntl sockets || echo "pcntl or sockets not available"

# Установка Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Создание необходимых директорий для конфигурации Xdebug
RUN mkdir -p /etc/php/8.1/fpm/conf.d

# Добавление конфигурации Xdebug
RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name 'xdebug.so' | head -n 1)" > /etc/php/8.1/fpm/conf.d/20-xdebug.ini \
    && echo "xdebug.mode=debug" >> /etc/php/8.1/fpm/conf.d/20-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /etc/php/8.1/fpm/conf.d/20-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /etc/php/8.1/fpm/conf.d/20-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /etc/php/8.1/fpm/conf.d/20-xdebug.ini

# Установка Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Копирование Composer из образа Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка рабочей директории
WORKDIR /var/www/symfony
