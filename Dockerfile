FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    procps \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    libxml2-dev \
    libonig-dev \
    && docker-php-ext-configure gd \
        --with-jpeg \
        --with-freetype \
    && docker-php-ext-install \
        pdo_mysql \
        intl \
        zip \
        gd \
        pcntl

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

RUN git config --global --add safe.directory /var/www

WORKDIR /var/www

RUN chmod -R 777 /var/www 2>/dev/null || true

CMD ["php-fpm"]
