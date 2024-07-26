# Départ de projet sous symfony avec Docker
1. Copier le fichier ``.end.dist`` et renommer en ``.env``
2. Lancez la commande: 
    ````
    docker compose up --build
    docker compo
    ````




# Projet Symfony avec Docker

Ce projet est un exemple d'application Symfony utilisant Docker pour gérer les services nécessaires (PHP, Nginx, MySQL).

## Prérequis

- Docker
- Docker Compose


## Configuration
Copiez le fichier ``.env.dist`` en ``.env`` et modifiez les variables d'environnement si nécessaire.

## Construire et démarrer les conteneurs Docker
````bash
docker-compose up --build
````

## Installer les dépendances PHP
La suite des commandes est à éxécuter dans le conteneur php. Pour se faire:
````bash
docker-compose exec php bash
composer install
````

## Exécuter les migrations de la base de données
````
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
`````

# Tester l'api
````
http://localhost:8080/api/badges
````

