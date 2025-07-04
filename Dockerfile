# Utilise une image PHP avec Apache et Composer
FROM php:8.3-apache

# Active mod_rewrite
RUN a2enmod rewrite

# Copie tout le code dans le conteneur
COPY . /var/www/html/

# Définit le répertoire de travail
WORKDIR /var/www/html/

# Installe Composer si pas déjà dans l'image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installe les dépendances PHP via Composer
RUN composer install

# Donne les bons droits (optionnel mais recommandé)
RUN chown -R www-data:www-data /var/www/html
