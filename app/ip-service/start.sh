#!/bin/bash

composer install
cp .env.example .env
php artisan key:generate

sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env
sed -i 's/# DB_HOST=127.0.0.1/DB_HOST=mysql/' .env
sed -i 's/# DB_PORT=3306/DB_PORT=3306/' .env
sed -i 's/# DB_DATABASE=laravel/DB_DATABASE=database_ip_service/' .env
sed -i 's/# DB_USERNAME=root/DB_USERNAME=root/' .env
sed -i 's/# DB_PASSWORD=/DB_PASSWORD=root_password/' .env

echo "ADMIN_EMAIL=admin@gmail.com" >> .env

php artisan migrate

php artisan db:seed

echo "✅ Now You could use a project."

