FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql

RUN groupmod -g ${GID} www-data \
    && usermod -u ${UID} -g www-data www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

WORKDIR /var/www/html
USER www-data
