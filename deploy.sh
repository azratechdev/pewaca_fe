#!/bin/bash
cd /var/www/pewaca_fe
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
chown -R www-data:www-data /var/www/pewaca_fe
