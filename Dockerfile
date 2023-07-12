# Use a imagem oficial do PHP 8.2
FROM php:8.2-fpm

# Atualize o sistema e instale as dependências necessárias
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Limpe o cache do sistema de pacotes
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instale as extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Defina o diretório de trabalho no contêiner
WORKDIR /var/www/html

# Copie o arquivo composer.json e o arquivo composer.lock para o diretório de trabalho
COPY composer.json composer.lock ./

# Instale as dependências do Laravel usando o Composer
RUN composer install --no-scripts --no-autoloader

# Copie todo o código do projeto para o diretório de trabalho
COPY . .

# Execute o comando de atualização do Composer para gerar o autoload
RUN composer dump-autoload

# Defina as permissões adequadas para o diretório de armazenamento do Laravel
RUN chown -R www-data:www-data storage

# Configure o arquivo de ambiente .env
RUN cp .env.example .env

# Gere a chave do aplicativo Laravel
RUN php artisan key:generate

# Exponha a porta 9000
EXPOSE 9000

# Comando de inicialização do servidor PHP-FPM
CMD ["php-fpm"]
