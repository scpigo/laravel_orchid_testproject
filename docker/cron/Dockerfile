FROM php:8.1-fpm

RUN apt-get update \
  && apt-get install -y \
             vim \
             libfreetype6-dev \
             libjpeg62-turbo-dev \
             libmcrypt-dev \
             libpng-dev \
             libwebp-dev \
             zlib1g-dev \
             libxml2-dev \
             libzip-dev \
             libonig-dev \
             graphviz \
             libcurl4-openssl-dev \
             pkg-config \
             libpq-dev \
             cron

RUN docker-php-ext-install pgsql \
  && docker-php-ext-install mysqli \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-install pdo_pgsql \
  && docker-php-ext-install intl \
  && docker-php-ext-install zip \
  && docker-php-ext-install exif \
  && docker-php-ext-install opcache \
  && docker-php-source delete

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-source delete
ENV COMPOSER_HOME=/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y git vim rsync sshpass bzip2

RUN pecl install xdebug && docker-php-ext-enable xdebug

ADD php.ini /usr/local/etc/php/php.ini

RUN chown -R www-data:www-data /composer

COPY crontab /etc/cron.d/crontab

RUN chmod 0644 /etc/cron.d/crontab

RUN crontab /etc/cron.d/crontab

RUN touch /var/log/cron.log

CMD bash -c "cron && php-fpm"
