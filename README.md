# TouchePasKlaxonne
#  TPK - Touche pas au Klaxon

**TPK** est une application PHP MVC permettant la gestion de trajets partagés entre agences, avec authentification, participation des utilisateurs et tableau de bord administrateur.

---

##  Sommaire

- [Description](#description)
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Architecture du projet](#architecture-du-projet)
- [Installation](#installation)
- [Configuration de la base de données](#configuration-de-la-base-de-données)
- [Commandes utiles](#commandes-utiles)
- [Documentation technique](#documentation-technique)
- [Organisation Git](#organisation-git)
- [Auteurs](#auteurs)

---

## Description

TPK est une plateforme web permettant :

- la création et la consultation de trajets proposés par des utilisateurs,
- la gestion des agences de départ et d’arrivée,
- la participation à un trajet,
- une interface d’administration dédiée.

Le projet a été réalisé dans le cadre d’un exercice (CEF Developpeur Web et Web Mobile) de mise en œuvre d’une architecture MVC en PHP pur, avec respect des bonnes pratiques de développement web (séparation des responsabilités, sécurisation, documentation...).

---

##  Fonctionnalités

- Création de trajets avec date, lieux 
- Participation à un trajet
- Authentification des utilisateurs
- CRUD sur les agences (admin uniquement)
- Contrôle de cohérence (même agence départ/arrivée interdite date Depart<Date Arrivée)
- Documentation générée automatiquement avec PHPDoc

---

## 🛠️ Technologies utilisées

- PHP 8.x
- MySQL / MariaDB (alwaysdata.com)
- Izniburak pour le router
- intérrogation de la base de donnée : Workbench
- test route (connexion) : Postman
- HTML / CSS et SCSS/ 
- Bootstrap (UI)
- PHPDoc (documentation)
- Composer (autoload + .env)
- Git / GitHub



##  Architecture du projet

TPK/
├── config/ Configuration de la BDD
│ └── Database.php
├── controllers/ Logique métier
├── models/ Accès aux données/requêtes SQL
├── views/ Interface utilisateur
├── public/ Ressources web (index.php, css, scss)
├── routes/ Fichier de routage (web.php)
├── test/ Tests unitaires (PHPUnit)
├── vendor/ Dépendances Composer
├── phpdoc.xml.dist Configuration PHPDoc
├── phpstan.neon Configuration PHPStan
├── phpunit.xml Configuration PHPUnit
├── composer.json Déclaration du projet PHP
└── README.txt Fichier de documentation

##  Installation


Cloner le dépôt :
git clone https://github.com/DigiDias/TPK
cd tpk

Installer les dépendances :
composer install

Créer un fichier .env :
DB_HOST=localhost
DB_NAME=digidias_tpk-db
DB_USER=digidias
DB_PASS=*******

## Commandes

composer install → Installation des dépendances

php phpDocumentor.phar → Génération de la documentation

vendor/bin/phpstan analyse → Analyse statique du code

vendor/bin/phpunit → Lancement des tests unitaires

php -S localhost:8000 -→ Démarrage d’un serveur local

##  Documentation Technique

Générée avec PHPDoc (php phpDocumentor.phar -c phpdoc.xml.dist)

Résultats dans le dossier docs/

Analyse du code avec PHPStan (vendor/bin/phpstan analyse)

Tests unitaires avec PHPUnit couvrant les opérations en base de données

##  Organisation Git

main : branche principale stable

dev : branche de développement

config : branche de configutation

feature/xxx : nouvelles fonctionnalités



## Auteur
Projet développé par : Sammy Gouljiar/ DigiDias
Encadré dans le cadre de : Formation / Developpeur web et web mobile / Centre Européen de la formation
GitHub : https://github.com/DigiDias