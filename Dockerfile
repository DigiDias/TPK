# Utilise l’image officielle PHP 8.3 avec Apache
FROM php:8.3-apache

# Installe les extensions nécessaires (ex : pdo_mysql pour MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# Active le module Apache rewrite
RUN a2enmod rewrite

# Copie le code source dans le container
COPY . /var/www/html/

# Définit le dossier racine
WORKDIR /var/www/html/

# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installe les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Donne les bons droits d'accès
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose le port utilisé par Apache
EXPOSE 80
