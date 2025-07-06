# Imagen base PHP 8.2 con FPM
FROM php:8.2-fpm

# Instalar dependencias de sistema necesarias
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    zip \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    npm

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo_mysql mbstring zip gd

# Instalar Node.js (versión 20)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos de Composer y npm para instalar dependencias
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Instalar dependencias PHP (sin dev) y JS
RUN composer install --no-dev --optimize-autoloader
RUN npm ci

# Copiar todo el proyecto
COPY . .

# Ejecutar build frontend
RUN npm run build

# Exponer puerto (ajustar si usas otro servidor)
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]
