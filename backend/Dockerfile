FROM php:8.3-fpm

# Instalar dependencias y el controlador MySQL para PDO
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto
COPY . /var/www/html

# Exponer el puerto
EXPOSE 9000
