FROM php:8.0-apache

RUN apt-get update

RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libpq-dev \
    libonig-dev \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    g++

RUN pecl install mongodb && docker-php-ext-enable mongodb

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    mbstring \
    pdo \
    pgsql \
    pdo_mysql \
    pdo_pgsql \
    zip \
    sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# chown -R www-data:www-data *
