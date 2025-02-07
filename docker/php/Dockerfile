FROM php:8.3-fpm

WORKDIR /srv/www

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libzip-dev

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG uid
RUN useradd -G www-data,root -u $uid -d /home/check24 check24
RUN mkdir -p /home/check24/.composer && \
    chown -R check24:check24 /home/check24
