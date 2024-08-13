# Départ de projet sous symfony avec Docker
1. Copier le fichier ``.end.dist`` et renommer en ``.env``
2. Lancez la commande: 
    ````
    docker compose up --build
    ````


# Projet Symfony avec Docker

Ce projet est un exemple d'application Symfony utilisant Docker pour gérer les services nécessaires (PHP, Nginx, MySQL).

# Prérequis

- Docker
- Docker Compose
- composer (Pour la gestion des package php)
- npm (pour la gestion des packages javascript)

## Installation des prérequis
TODO : to test, (pas certain que se soit nécessaire comme le projet est déjà initialisé sur docker)

### Installer Composer 
TODO
````
composer install
````

### Installer NPM
Téléchargez et installez Node.js (qui inclut npm) : https://nodejs.org/fr  

Rendez-vous sur le site officiel de Node.js et téléchargez la version LTS recommandée.  
Suivez les instructions d'installation.  

Initialisez npm dans votre projet, dans le répertoire de votre projet:  
````bash
npm init
````

Mise en place des package boostrap et sass 
````bash
npm install bootstrap sass
````


## Configuration
Copiez le fichier ``.env.dist`` en ``.env`` et modifiez les variables d'environnement si nécessaire.

# Déploiement

## Construire et démarrer les conteneurs Docker
````bash
docker-compose up --build
````
La suite des commandes est à éxécuter dans le conteneur php. Pour se faire:
````bash
docker-compose exec php bash
````
## Installer les dépendances PHP

````bash
composer install
````

# En cas d'erreur
si lors du build:
> failed to solve: process "/bin/sh -c chown -R www-data:www-data /var/www/var" did not complete successfully: exit code: 1

le dossier ``var`` n'existerait pas, il faut lancer:
````
compose install
docker-compose up --build
`````

NOTE: il y a surement des points d'amélioration à faire sur le dockerFile


## Exécuter les migrations de la base de données
````
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
`````

# Tester l'api
````
http://localhost:8080/status
````
