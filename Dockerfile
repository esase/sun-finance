FROM php:7.1.3-apache

MAINTAINER Alex Ermashev <alexermashev@gmail.com>

RUN apt-get update && apt-get install -y zlib1g-dev libpng-dev 
RUN apt-get install -y \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev libxpm-dev \
    libfreetype6-dev \
    git \ 
    curl \
    poppler-utils

RUN docker-php-ext-configure gd \
    --with-gd \
    --with-webp-dir \
    --with-jpeg-dir \
    --with-png-dir \
    --with-zlib-dir \
    --with-xpm-dir \
    --with-freetype-dir \
    --enable-gd-native-ttf

RUN docker-php-ext-install pdo_mysql mysqli zip gd
RUN a2enmod rewrite
RUN a2enmod headers
RUN a2enmod expires

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
