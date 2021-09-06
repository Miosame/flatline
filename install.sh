#!/usr/bin/env bash
docker-compose build

# merge environment files
# src: https://gist.github.com/mattkenefick/6ff3d3b4b17c1e9f43d0908cf830bbd2
cat .env > tmp0
cat $(pwd)/php-mysql-image/html/.env.example >> tmp0
awk -F "=" '!a[$1]++' tmp0 > tmp1 && mv tmp1 $(pwd)/php-mysql-image/html/.env && rm ./tmp0

# install vendor files
docker run --rm -v $(pwd)/php-mysql-image/html:/app composer install --ignore-platform-reqs

# generate laravel app-key
docker run -t --rm -v $(pwd)/php-mysql-image/html/:/var/www vcarreira/artisan key:generate

# source the dotenv for mysql pings
source $(pwd)/php-mysql-image/html/.env

# PR welcome
chmod -R 777 $(pwd)/php-mysql-image/html/storage/

# make sure mysql is started and accepting connections
docker-compose up -d mysql
while ! docker-compose exec mysql mysqladmin --user="$DB_USERNAME" --password="$DB_PASSWORD" --host "$DB_HOST" ping --silent &> /dev/null ; do
    echo "Waiting for database connection..."
    sleep 10
done

# bring the containers up
docker-compose up -d

# migrate the database
docker-compose exec php php artisan migrate:refresh
