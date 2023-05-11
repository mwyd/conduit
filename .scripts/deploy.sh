#!/bin/bash
set -e

(php artisan down) || true

git pull origin master

npm install
npm run build

composer install --no-dev --no-interaction --optimize-autoloader

php artisan optimize
php artisan migrate --force
php artisan up