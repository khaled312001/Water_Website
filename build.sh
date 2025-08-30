#!/bin/bash

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Generate application key if not exists
php artisan key:generate --force

# Clear and cache config
php artisan config:cache

# Clear and cache routes
php artisan route:cache

# Clear and cache views
php artisan view:cache

# Build frontend assets
npm run build

# Create storage link
php artisan storage:link

echo "Build completed successfully!" 