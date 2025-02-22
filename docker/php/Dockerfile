FROM php:8.1-fpm

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

RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install pcntl sockets || echo "pcntl or sockets not available"

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN mkdir -p /etc/php/8.1/fpm/conf.d

RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name 'xdebug.so' | head -n 1)" > /etc/php/8.1/fpm/conf.d/20-xdebug.ini \
    && echo "xdebug.mode=debug" >> /etc/php/8.1/fpm/conf.d/20-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /etc/php/8.1/fpm/conf.d/20-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /etc/php/8.1/fpm/conf.d/20-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /etc/php/8.1/fpm/conf.d/20-xdebug.ini

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/symfony
