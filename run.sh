#!/bin/sh

composer install
php artisan migrate
php artisan orchid:install
php artisan orchid:admin admin admin@admin.com admin
php artisan roles:init
php artisan storage:link
