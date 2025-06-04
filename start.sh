#!/usr/bin/env bash

# Rutas para ejecutables en imágenes Alpine (se asume que estas son correctas)
PHP_BIN=/usr/bin/php
PHP_FPM_BIN=/usr/sbin/php-fpm
NGINX_BIN=/usr/sbin/nginx

echo "Running database migrations..."
$PHP_BIN artisan migrate --force
echo "Creating storage link..."
$PHP_BIN artisan storage:link
echo "Caching Laravel configuration..."
$PHP_BIN artisan config:cache
echo "Caching Laravel routes..."
$PHP_BIN artisan route:cache
echo "Caching Laravel views..."
$PHP_BIN artisan view:cache
echo "Optimizing Laravel application..."
$PHP_BIN artisan optimize

echo "Starting PHP-FPM..."
$PHP_FPM_BIN -D

echo "Starting Nginx..."
$NGINX_BIN -g "daemon off;"

echo "Application started successfully."