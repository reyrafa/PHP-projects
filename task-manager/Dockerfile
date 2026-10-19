
# syntax=docker/dockerfile:1

# Stage 1: Build frontend assets
FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build


# Shared PHP runtime base
FROM dunglas/frankenphp:1-php8.4-bookworm AS php-base

RUN install-php-extensions \
    pdo_mysql \
    bcmath \
    gd \
    intl \
    zip \
    opcache \
    pcntl \
    exif

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"


# Stage 2: Install production PHP dependencies
FROM php-base AS vendor

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-progress \
    --no-scripts \
    --no-autoloader

COPY . .

RUN composer dump-autoload --no-dev --optimize --no-scripts \
    && php artisan package:discover --ansi


# Stage 3: Final runtime image
FROM php-base AS runtime

WORKDIR /app

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    SERVER_NAME=:80

COPY --from=vendor /app /app

COPY --from=frontend /app/public/build /app/public/build

RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache

EXPOSE 80
