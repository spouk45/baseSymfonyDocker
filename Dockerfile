FROM php:8.3.9-fpm

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install intl opcache pdo pdo_mysql zip

# Installer Node.js et npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers composer.json et composer.lock
COPY composer.json composer.lock ./

# Installer les dépendances PHP avec Composer
RUN composer install --no-autoloader --no-scripts

# Copier les autres fichiers de l'application
COPY . .

# Construire les fichiers d'autoload
RUN composer dump-autoload --optimize

# Installer les dépendances npm
COPY package.json package-lock.json ./
RUN npm install

# Installer webpack-cli pour pouvoir utiliser Webpack via npx
RUN npm install -D webpack-cli
# Compiler les assets 
RUN npx webpack --config webpack.config.js

# Chmod pour le répertoire var
RUN chown -R www-data:www-data /var/www/var

# Exposer le port
EXPOSE 9000

CMD ["php-fpm"]
