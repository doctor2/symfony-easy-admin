FROM php:7.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    wget \
    libicu-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libpq-dev \
    libxml2-dev \
    git \
    unzip \
    zlibc \
    libzip-dev \
    && pecl install redis mongodb-1.7.4 \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini \
    && usermod -u 1000 www-data

# Install extensions
RUN docker-php-ext-install \
    zip \
    iconv \
    soap \
    sockets \
    intl \
    pdo \
    pdo_mysql \
    exif \
    pcntl

# Set working directory
WORKDIR /symfony