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
    git \ 
    nodejs \ 
    bash \ 
    php82-mbstring \   
    php82-exif \        
    php82-bcmath \      
    php82-gd \         
    php82-pdo_mysql \   
    php82-pdo_pgsql    


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

# 4. COPIAR CÓDIGO Y DEFINIR COMANDO DE INICIO
# Copiar todo el código de tu proyecto al directorio de trabajo en el contenedor.
COPY . /var/www/html

# Dar permisos de ejecución al script de inicio
RUN chmod +x /var/www/html/start.sh

# Definir el comando que se ejecutará cuando el contenedor se inicie.
CMD ["./start.sh"]