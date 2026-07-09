#!/bin/sh
set -e

php scripts/wait-for-db.php

php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

if [ ! -L public/storage ]; then
    php artisan storage:link
fi

exec "$@"
