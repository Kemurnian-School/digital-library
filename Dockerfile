FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip procps \
    libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libicu-dev libxml2-dev libonig-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo_mysql intl zip gd pcntl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && git config --global --add safe.directory /var/www \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

# Cache composer dependencies as a layer
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-interaction

# Cache npm dependencies as a layer
COPY package.json package-lock.json ./
RUN npm ci

COPY . .

RUN composer dump-autoload --optimize \
    && chmod -R 777 storage bootstrap/cache

CMD ["php-fpm"]
