FROM php:8.4.1-fpm

# installing dependencies
RUN apt-get update && apt-get install -y \
       git \
       nano \
       iputils-ping \
       ffmpeg \
       libfreetype6-dev \
       libicu-dev \
       libgmp-dev \
       libjpeg62-turbo-dev \
       libpng-dev \
       libwebp-dev \
       libxpm-dev \
       libzip-dev \
       unzip \
       zlib1g-dev \
       npm

# configuring php extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-configure intl


# installing php extension
RUN docker-php-ext-install bcmath calendar exif gd gmp intl mysqli pdo pdo_mysql zip

# installing composer
COPY --from=composer:2.7 /usr/bin/composer /usr/local/bin/composer

# installing node js
COPY --from=node:23 /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node:23 /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/

RUN npm install -g tldr

WORKDIR /app/ip-service

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions xdebug
COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"


