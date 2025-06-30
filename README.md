# TouchePasKlaxonne
# 🚗 TPK - Transport Partagé Kilométrique

**TPK** est une application PHP MVC permettant la gestion de trajets partagés entre agences, avec authentification, participation des utilisateurs et tableau de bord administrateur.

---

## 🗂️ Sommaire

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

## 📖 Description

TPK est une plateforme web permettant :

- la création et la consultation de trajets proposés par des utilisateurs,
- la gestion des agences de départ et d’arrivée,
- la participation à un trajet,
- une interface d’administration dédiée.

Le projet a été réalisé dans le cadre d’un exercice de mise en œuvre d’une architecture MVC en PHP pur, avec respect des bonnes pratiques de développement web (séparation des responsabilités, sécurisation, documentation...).

---

## ✅ Fonctionnalités

- Création de trajets avec date, lieux et coordonnées
- Participation à un trajet
- Authentification des utilisateurs
- CRUD sur les agences (admin uniquement)
- Contrôle de cohérence (même agence départ/arrivée interdite)
- Documentation générée automatiquement avec PHPDoc

---

## 🛠️ Technologies utilisées

- PHP 8.x
- MySQL / MariaDB
- HTML / CSS / 
- Bootstrap (UI)
- PHPDoc (documentation)
- Composer (autoload + .env)
- Git / GitHub

---

## 🧱 Architecture du projet

