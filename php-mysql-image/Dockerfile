FROM php:8-fpm-buster
WORKDIR /usr/share/nginx/html
RUN apt-get update
RUN docker-php-ext-install pdo_mysql
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./html .