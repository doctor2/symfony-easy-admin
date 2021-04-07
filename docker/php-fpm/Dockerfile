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
    libzip-dev

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