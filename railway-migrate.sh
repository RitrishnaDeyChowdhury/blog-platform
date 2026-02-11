#!/bin/sh
# Run Laravel migrations automatically
php artisan migrate --force

# Start the Laravel app
php -S 0.0.0.0:$PORT -t public