FROM php:8.2-apache

# Activa el mòdul mod_rewrite d'Apache
RUN a2enmod rewrite

# Modifica el php.ini per mostrar els errors
RUN echo "display_errors = On" >> /usr/local/etc/php/php.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/php.ini
RUN echo "file_uploads = On" >> /usr/local/etc/php/php.ini
RUN echo "upload_max_filesize = 500M" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size = 500M" >> /usr/local/etc/php/php.ini

# Cambia el documentroot a public
RUN sed -i "s|/var/www/html|/var/www/html/public |g" /etc/apache2/sites-available/000-default.conf

# Habilita l'ús de fitxers .htaccess a la carpeta /var/www/html
RUN sed -i "s|</VirtualHost>|\t<Directory /var/www/html>\n\t    Options Indexes FollowSymLinks\n\t    AllowOverride All\n\t    Require all granted\n</Directory>\n </VirtualHost>|g" /etc/apache2/sites-available/000-default.conf

# Instala las extensiones necesarias para MySQL
RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql

# Instala las dependencias necesarias para la extensión gd
RUN apt-get install -y build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev

# Instala la extensión gd
RUN docker-php-ext-install gd

# Otorga permisos al servidor Apache
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Reinicia Apache para aplicar los cambios
RUN service apache2 restart

# Exponer el puerto 80
EXPOSE 80