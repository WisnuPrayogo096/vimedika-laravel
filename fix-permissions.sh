#!/bin/bash

# Fix Laravel storage permissions
# Run this script on your Linux/Unix server

echo "Fixing Laravel storage permissions..."

# Set ownership to web server user (usually www-data, apache, or nginx)
# Replace 'www-data' with your actual web server user
sudo chown -R www-data:www-data /var/www/vimedika-laravel/storage
sudo chown -R www-data:www-data /var/www/vimedika-laravel/bootstrap/cache

# Set proper permissions
sudo chmod -R 775 /var/www/vimedika-laravel/storage
sudo chmod -R 775 /var/www/vimedika-laravel/bootstrap/cache

# Make sure the web server can write to these directories
sudo chmod -R 755 /var/www/vimedika-laravel/storage/framework/views
sudo chmod -R 755 /var/www/vimedika-laravel/storage/framework/cache
sudo chmod -R 755 /var/www/vimedika-laravel/storage/framework/sessions
sudo chmod -R 755 /var/www/vimedika-laravel/storage/logs

echo "Permissions fixed successfully!"
echo "If you're still having issues, try:"
echo "sudo chmod -R 777 /var/www/vimedika-laravel/storage"
echo "sudo chmod -R 777 /var/www/vimedika-laravel/bootstrap/cache"
