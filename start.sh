#!/usr/bin/env bash

# Este script se ejecuta cuando el contenedor Docker inicia.

# Ruta donde se encuentran los ejecutables en la imagen php-fpm-alpine
PHP_BIN=/usr/local/bin/php
PHP_FPM_BIN=/usr/local/sbin/php-fpm # php-fpm suele estar en /usr/local/sbin en Alpine
NGINX_BIN=/usr/sbin/nginx          # Nginx suele estar en /usr/sbin en Alpine

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