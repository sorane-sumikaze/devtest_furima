FROM php:8.5.3-fpm-bookworm

COPY php.ini /usr/local/etc/php/

RUN set -eux; \
  apt-get update; \
  apt-get install -y --no-install-recommends \
  default-mysql-client \
  zlib1g-dev \
  libzip-dev \
  unzip \
  ca-certificates \
  curl \
  ; \
  docker-php-ext-install pdo_mysql zip; \
  rm -rf /var/lib/apt/lists/*

RUN set -eux; \
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
  composer --version

WORKDIR /var/www