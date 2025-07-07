FROM php:8.2-apache

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

# Activer mod_rewrite pour les .htaccess
RUN a2enmod rewrite

# Modifier la configuration Apache pour permettre les .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copier les fichiers de l'application
COPY . /var/www/html/

# Définir le répertoire de travail
WORKDIR /var/www/html/

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installer les dépendances PHP
RUN composer install --prefer-dist --no-dev --optimize-autoloader

# Droits d'accès (optionnel)
RUN chown -R www-data:www-data /var/www/html
