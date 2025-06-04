#!/usr/bin/env bash

# Este script se ejecuta cuando el contenedor Docker inicia.

# Rutas correctas para ejecutables en imágenes Alpine
PHP_BIN=/usr/bin/php          # Cambiado de /usr/local/bin/php
PHP_FPM_BIN=/usr/sbin/php-fpm # Manteniendo /usr/local/sbin/php-fpm o /usr/sbin/php-fpm
NGINX_BIN=/usr/sbin/nginx     # Cambiado de /usr/local/bin/nginx

# 1. Ejecutar migraciones de la base de datos:
echo "Running database migrations..."
$PHP_BIN artisan migrate --force

# 2. Crear enlace simbólico de almacenamiento:
echo "Creating storage link..."
$PHP_BIN artisan storage:link

# 3. Optimizar Laravel para producción:
echo "Caching Laravel configuration..."
$PHP_BIN artisan config:cache
echo "Caching Laravel routes..."
$PHP_BIN artisan route:cache
echo "Caching Laravel views..."
$PHP_BIN artisan view:cache
echo "Optimizing Laravel application..."
$PHP_BIN artisan optimize

# 4. Iniciar PHP-FPM en segundo plano:
echo "Starting PHP-FPM..."
$PHP_FPM_BIN -D

# 5. Iniciar Nginx en primer plano:
echo "Starting Nginx..."
$NGINX_BIN -g "daemon off;"

echo "Application started successfully."