# Build frontend con Node Debian
FROM node:20 AS frontend-builder

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build


# Backend Laravel PHP
FROM php:8.2-fpm-alpine

RUN apk add --no-cache bash curl git zip unzip libzip-dev oniguruma-dev

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install zip mbstring bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

COPY --from=frontend-builder /app/public/build ./public/build

RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data storage bootstrap/cache

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

EXPOSE 9000

CMD ["php-fpm"]
