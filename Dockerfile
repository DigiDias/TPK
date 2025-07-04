FROM php:8.2-apache

# Active mod_rewrite
RUN a2enmod rewrite

# Copie ton code dans le conteneur
COPY . /var/www/html/

# Copie ton .htaccess si nécessaire
COPY .htaccess /var/www/html/.htaccess

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html
