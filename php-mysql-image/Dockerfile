FROM php:7.2.15-fpm-stretch
WORKDIR /usr/share/nginx/html
RUN apt-get update
RUN docker-php-ext-install pdo_mysql
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./html .