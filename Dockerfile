# Dockerfile

# 1. IMAGEN BASE:
# Inicia la construcción desde una imagen oficial de PHP.
# Usamos 'php:8.2-fpm-alpine' porque:
#   - 'php:8.2-fpm': Proporciona PHP-FPM (FastCGI Process Manager), que es necesario para que Nginx se comunique con PHP.
#   - '-alpine': Es una versión muy ligera y pequeña de Linux, ideal para producción ya que reduce el tamaño final de la imagen.
#     Puedes usar 'php:8.2-fpm' (basado en Debian) si lo prefieres, pero será más grande.
FROM php:8.2-fpm-alpine

# 2. INSTALAR DEPENDENCIAS DEL SISTEMA Y EXTENSIONES DE PHP:
# 'apk add --no-cache' es el gestor de paquetes de Alpine.
# Instalamos herramientas y librerías necesarias:
#   - nginx: El servidor web que servirá tu aplicación.
#   - postgresql-client: Herramientas para conectar a la base de datos PostgreSQL de Render.
#   - libpq: Librería necesaria para la extensión PDO_PGSQL de PHP.
#   - libzip-dev, libpng-dev, jpeg-dev: Dependencias para extensiones PHP comunes como 'zip' o 'gd'.
#   - git: Necesario si tu aplicación usa Git internamente o si Composer lo requiere para ciertas dependencias.
#   - nodejs: El gestor de paquetes de Node.js, para `npm install` y `npm run build`.
#   - bash: Asegúrate de que bash esté disponible para start.sh
#
# 'docker-php-ext-install': Instala extensiones de PHP.
#   - pdo_mysql: Para MySQL (aunque uses PostgreSQL en Render, es buena práctica si la app lo soporta).
#   - pdo_pgsql: ¡CRUCIAL para conectar a la base de datos PostgreSQL de Render!
#   - mbstring, exif, pcntl, bcmath, gd: Extensiones comunes que Laravel y otras librerías suelen requerir.
# 'docker-php-ext-enable': Habilita las extensiones recién instaladas.
# 2. INSTALAR DEPENDENCIAS DEL SISTEMA Y EXTENSIONES DE PHP:
# Actualizar y añadir paquetes base
RUN apk update && apk add --no-cache \ 
    nginx \ 
    postgresql-client \ 
    postgresql-dev \ 
    libzip-dev \ 
    libpng-dev \ 
    jpeg-dev \ 
    freetype-dev \ 
    mysql-client \ 
    mysql-dev \ 
    git         # <-- ¡ESTA ES LA ÚLTIMA LÍNEA DE ESTA INSTRUCCIÓN, NO LLEVA \!
# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd
# Habilitar extensiones de PHP
RUN docker-php-ext-enable pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Limpiar caché de apk
RUN rm -rf /var/cache/apk/*

# 3. DEFINIR DIRECTORIO DE TRABAJO:
# Establece el directorio donde se copiará tu código y donde se ejecutarán los comandos.
WORKDIR /var/www/html

# 4. COPIAR ARCHIVOS DE LA APLICACIÓN:
# Copia todo el contenido de tu proyecto local (desde la raíz del Dockerfile) al directorio de trabajo en el contenedor.
# El archivo '.dockerignore' (que crearemos después) controlará qué archivos NO se copian.
# Dockerfile

# ... (tus RUN apk add y docker-php-ext-install/enable) ...

# === NUEVAS LÍNEAS DE DEPURACIÓN ===
# Ejecuta 'which' para encontrar las rutas exactas de los ejecutables
# === FIN DE LAS NUEVAS LÍNEAS DE DEPURACIÓN ===

COPY . .
# ... (el resto de tu Dockerfile) ...

# 5. CONFIGURAR NGINX:
# Copia el archivo de configuración personalizado de Nginx desde tu proyecto a la ubicación estándar de Nginx en el contenedor.
# Esto es vital para que Nginx sepa cómo servir tu aplicación Laravel (apuntando a `public/index.php`).
COPY .docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# 6. EXPONER PUERTO:
# Informa a Docker que el contenedor escuchará en el puerto 80 (el puerto HTTP estándar) para el tráfico web.
EXPOSE 80

# 7. COMANDO DE INICIO (CMD):
# Este comando indica qué se ejecutará cuando el contenedor se inicie.
# Aquí, simplemente llamamos a un script que crearemos, 'start.sh', que se encargará de iniciar PHP-FPM y Nginx.
CMD ["./start.sh"]