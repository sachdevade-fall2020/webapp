#!/bin/bash

# Change ownership
echo "changing ownership..."
sudo chown -R ubuntu:www-data /var/www/html
echo "exit code: $?"
echo "ownership changed"

# Create environment file
echo "copying env file..."
cp /var/www/html/.env.example /var/www/html/.env
echo "env file copied"

# Install composer dependencies
echo "Installing composer dependencies..."
/usr/bin/composer install -d /var/www/html/
echo "exit code: $?"
echo "Composer dependencies installed"

# Clear any previous cached views and optimize the application
echo "executing artisan commands..."
php /var/www/html/artisan key:generate
php /var/www/html/artisan view:clear
php /var/www/html/artisan config:cache
php /var/www/html/artisan migrate
php /var/www/html/artisan route:cache
echo "artisan commands executed"

# Setup the various file and folder permissions for Laravel
echo "fixing permissions..."
sudo find /var/www/html -type d -exec chmod 755 {} +
echo "exit code: $?"
sudo find /var/www/html -type f -exec chmod 644 {} +
echo "exit code: $?"
sudo chgrp -R www-data /var/www/html/storage /var/www/html/bootstrap/cache
echo "exit code: $?"
sudo chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache
echo "exit code: $?"
echo "permissions fixed"