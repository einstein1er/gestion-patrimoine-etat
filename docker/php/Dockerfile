FROM php:8.4-cli-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        git \
        unzip \
        libpq-dev \
        libonig-dev \
        libzip-dev \
        libicu-dev \
    && docker-php-ext-install -j2 \
        pdo_pgsql \
        mbstring \
        zip \
        intl \
        bcmath \
        pcntl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

ENV COMPOSER_HOME=/tmp/composer

WORKDIR /app

CMD ["php", "--version"]
