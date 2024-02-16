FROM php:8.1.27-fpm

# install dependencies
RUN apt-get update && apt-get install -y \
    wget \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libz-dev \
    libzip-dev

# clear cache
RUN apt-get autoclean -y

# install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# install mysql
RUN apt-get install -y default-mysql-client

# get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP Zip extensions
RUN pecl install zlib zip

# Install PECL and PEAR extensions
RUN pecl install xdebug-3.1.6

# Enable PECL and PEAR extensions
RUN docker-php-ext-enable xdebug

# Install and Enable Sockets Extensions
RUN docker-php-ext-install sockets
RUN docker-php-ext-enable sockets

# Install and Enable Intl Extensions
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl

# Copy php.ini into image
RUN echo xdebug.mode=coverage > /usr/local/etc/php/php.ini

# set working directory
WORKDIR /var/www/html

COPY --chown=www-data . /var/www/html/

# when building we need to force dev env so that dusk loads, otherwise it will refuse because of prod env
RUN echo APP_ENV=testing > .env

# set empty key so that we can generate it later
RUN echo APP_KEY= >> .env
