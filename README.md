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
- ~~Docker Compose~~
- ~~composer (Pour la gestion des package php)~~
- ~~npm (pour la gestion des packages javascript)~~

## Installation des prérequis (normalement plus besoin, à confirme)
TODO : to test, (pas certain que se soit nécessaire comme le projet est déjà initialisé sur docker)

### Installer Composer (normalement plus besoin, à confirme)
TODO
````
composer install
````

### Installer NPM (normalement plus besoin, à confirme)
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
Un dossier ``var`` et ``vendor`` devrait apparaitre à la racine du dossier.  

La suite des commandes est à éxécuter dans le conteneur php. Pour se faire:
````bash
docker-compose exec php bash
````
## Exécuter les migrations de la base de données si nécessaire
````
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
`````

# Tester l'api
````
http://localhost:8082/ping
````

Application des fixtures si besoin pour alimenter la base en données de test:
````bash
php bin/console d:f:l
````
