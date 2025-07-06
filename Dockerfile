# Etapa 1: Build frontend (Node + npm)
FROM node:20-alpine AS frontend-builder

WORKDIR /app

# Copia package.json y package-lock.json para instalar dependencias
COPY package*.json ./

RUN npm install

# Copia todo el proyecto (para poder ejecutar build de assets)
COPY . .

RUN npm run build


# Etapa 2: Backend Laravel (PHP)
FROM php:8.2-fpm-alpine

# Instalar dependencias del sistema necesarias
RUN apk add --no-cache \
    bash curl git zip unzip libzip-dev oniguruma-dev

# Instalar extensiones PHP necesarias por separado para evitar memory issues
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install zip mbstring bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar todo el proyecto (excepto node_modules y build) desde el contexto
COPY . .

# Copiar los assets compilados de la etapa frontend-builder
COPY --from=frontend-builder /app/public/build ./public/build

# Instalar dependencias PHP
RUN composer install --optimize-autoloader --no-dev

# Configurar permisos para storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Cachear config, rutas y vistas
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Ejecutar migraciones (opcional)
# RUN php artisan migrate --force

# Exponer puerto php-fpm
EXPOSE 9000

CMD ["php-fpm"]
