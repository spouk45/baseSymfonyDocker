FROM php:8.3.9-fpm

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install intl opcache pdo pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier uniquement le fichier composer.json et composer.lock (si présent)
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN composer install --no-autoloader --no-scripts

# Copier le reste des fichiers
COPY . .

# Construire les fichiers d'autoload
RUN composer dump-autoload --optimize

# Chmod pour le répertoire var
RUN chown -R www-data:www-data /var/www/var

# Exposer le port
EXPOSE 9000

CMD ["php-fpm"]
