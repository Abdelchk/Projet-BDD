# Dockerfile
FROM php:8.2-fpm-alpine

# Installer les dépendances système
RUN apk add --no-cache bash git zip unzip

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Installer Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier l'intégralité du projet dans le conteneur
COPY . .

# # Installer les dépendances PHP
# ARG APP_ENV=prod
# RUN if [ "$APP_ENV" = "prod" ]; then composer install --no-dev --optimize-autoloader; else composer install; fi

# # Donner les droits sur le répertoire var
# RUN chown -R www-data:www-data /var/www/var

# Exposer le port 8000
EXPOSE 8000

# Lancer le serveur Symfony
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
