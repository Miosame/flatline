#!/usr/bin/env bash
docker-compose build

# merge environment files
# src: https://stackoverflow.com/questions/57691556/shell-script-for-merging-dotenv-files-with-duplicate-keys
sort -u -t '=' -k 1,1 .env $(pwd)/php-mysql-image/html/.env.example > $(pwd)/php-mysql-image/html/.env

# install vendor files
docker run --rm -v $(pwd)/php-mysql-image/html:/app composer install

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
