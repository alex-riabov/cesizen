FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libicu-dev libzip-dev zip \
    && docker-php-ext-install intl pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
