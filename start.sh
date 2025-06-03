#!/usr/bin/env bash

# Este script se ejecuta cuando el contenedor Docker inicia.

# 1. Ejecutar migraciones de la base de datos:
# 'php artisan migrate --force' ejecuta las migraciones de tu base de datos.
# '--force' es necesario en entornos de producción para confirmar la ejecución.
echo "Running database migrations..."
php artisan migrate --force

# 2. Crear enlace simbólico de almacenamiento:
# 'php artisan storage:link' crea un enlace simbólico de 'storage/app/public' a 'public/storage'.
# Esto es necesario para que las imágenes subidas a 'storage/app/public' sean accesibles públicamente.
# NOTA: En el plan gratuito de Render, las imágenes guardadas localmente NO SON PERSISTENTES.
# Se perderán si el contenedor se reinicia. Para persistencia, necesitarías AWS S3 o similar.
echo "Creating storage link..."
php artisan storage:link

# 3. Optimizar Laravel para producción:
# Estos comandos mejoran el rendimiento de Laravel en producción al cachear configuraciones, rutas y vistas.
echo "Caching Laravel configuration..."
php artisan config:cache
echo "Caching Laravel routes..."
php artisan route:cache
echo "Caching Laravel views..."
php artisan view:cache
echo "Optimizing Laravel application..."
php artisan optimize

# 4. Iniciar PHP-FPM en segundo plano:
# 'php-fpm -D' inicia el PHP FastCGI Process Manager en modo daemon (segundo plano).
# Es el proceso que ejecuta tu código PHP y se comunica con Nginx.
echo "Starting PHP-FPM..."
php-fpm -D

# 5. Iniciar Nginx en primer plano:
# 'nginx -g "daemon off;"' inicia el servidor web Nginx en primer plano.
# ¡Esto es crucial! El proceso principal del contenedor (el último comando en CMD) debe permanecer en primer plano
# para que el contenedor siga ejecutándose. Si se ejecuta en segundo plano, el contenedor se apagará.
echo "Starting Nginx..."
nginx -g "daemon off;"

echo "Application started successfully."