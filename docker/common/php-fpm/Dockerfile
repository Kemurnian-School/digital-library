FROM php:8.4-cli

# Args for host user matching + xdebug
ARG UID=1000
ARG GID=1000
ARG NODE_VERSION=22.0.0
ARG XDEBUG_ENABLED=true
ARG XDEBUG_MODE
ARG XDEBUG_HOST
ARG XDEBUG_IDE_KEY
ARG XDEBUG_LOG
ARG XDEBUG_LOG_LEVEL

# System dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    git \
    libonig-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-install -j$(nproc) \
       pdo_mysql \
       intl \
       zip \
       bcmath \
    && pecl install redis xdebug \
    && docker-php-ext-enable redis \
    && apt-get autoremove -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Xdebug conditional config
RUN if [ "${XDEBUG_ENABLED}" = "true" ]; then \
      docker-php-ext-enable xdebug && \
      echo "xdebug.mode=${XDEBUG_MODE}" >> /usr/local/etc/php/conf.d/xdebug.ini && \
      echo "xdebug.idekey=${XDEBUG_IDE_KEY}" >> /usr/local/etc/php/conf.d/xdebug.ini && \
      echo "xdebug.client_host=${XDEBUG_HOST}" >> /usr/local/etc/php/conf.d/xdebug.ini && \
      echo "xdebug.log=${XDEBUG_LOG}" >> /usr/local/etc/php/conf.d/xdebug.ini && \
      echo "xdebug.log_level=${XDEBUG_LOG_LEVEL}" >> /usr/local/etc/php/conf.d/xdebug.ini && \
      echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini ; \
    fi

# Add non-root user matching host UID/GID
RUN groupadd -g ${GID} www || true \
    && useradd -m -u ${UID} -g ${GID} -s /bin/bash www

WORKDIR /var/www

# Install NVM + Node
RUN export NVM_DIR="$HOME/.nvm" && \
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.0/install.sh | bash && \
    . "$NVM_DIR/nvm.sh" && \
    nvm install ${NODE_VERSION} && \
    nvm alias default ${NODE_VERSION} && \
    echo 'export NVM_DIR="$HOME/.nvm"' >> ~/.bashrc && \
    echo '[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"' >> ~/.bashrc

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- \
      --install-dir=/usr/local/bin --filename=composer

USER www

# Entry point kept empty (so "bash" is default)
ENTRYPOINT []
CMD ["bash"]
