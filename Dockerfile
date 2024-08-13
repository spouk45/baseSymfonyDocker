FROM php:8.3.9-fpm

# Installer les extensions PHP nécessaires, Node.js, npm et Composer
RUN apt-get update && \
    apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install intl opcache pdo pdo_mysql zip \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && mkdir -p /var/www \
    && chown -R www-data:www-data /var/www \
    && curl -fsSL https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers composer.json et composer.lock
COPY composer.json composer.lock ./

# Installer les dépendances PHP avec Composer
RUN composer install --no-autoloader --no-scripts

# Copier les autres fichiers de l'application
COPY . .

# Installer les dépendances NPM et Webpack
RUN npm install \
    && npm install -D webpack-cli \
    && npm install mini-css-extract-plugin css-loader sass-loader \
    && composer dump-autoload --optimize

# Exposer le port pour PHP-FPM
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]
