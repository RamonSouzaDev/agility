# Use a versão do PHP desejada como base
FROM php:8.1-fpm

# Instale as dependências necessárias
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Instale as extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath opcache

# Copie o arquivo de configuração do PHP
COPY ./docker/php.ini /usr/local/etc/php/php.ini

# Defina o diretório de trabalho no container
WORKDIR /var/www/html
COPY . .

# Instale as dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer update
RUN composer install --no-interaction --no-dev --prefer-dist

# Execute os comandos do Laravel
RUN php artisan key:generate

# Copiar o arquivo .env
COPY .env .

# Exponha a porta 80 para o servidor web
EXPOSE 80

# Inicie o servidor PHP-FPM
CMD ["php-fpm"]
