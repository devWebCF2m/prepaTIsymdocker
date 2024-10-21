FROM composer:2.4.2 as composer

##################################

FROM php:8.1-fpm-alpine3.16

RUN apk add --no-cache \
    bash=~5.1 \
    git=~2.36 \
    icu-dev=~71.1

RUN mkdir -p /usr/src/app \
    && apk add --no-cache --virtual=.build-deps \
        autoconf=~2.71 \
        g++=~11.2 \
        make=~4.3 \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" intl pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu intl \
    && apk del .build-deps

WORKDIR /usr/src/app

COPY composer.json /usr/src/app/composer.json
COPY composer.lock /usr/src/app/composer.lock

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer install --no-scripts

COPY . /usr/src/app

#RUN chown -R 1000:1000 /usr/src/app
