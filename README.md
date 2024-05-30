# MiniFramework PHP

MiniFramework est un mini-framework PHP développé pour démontrer l'utilisation des concepts de Programmation Orientée Objet (POO) dans le développement web. Ce projet inclut des fonctionnalités de routage, de gestion des requêtes et des réponses HTTP, d'injection de dépendances, de vues, et de gestion des erreurs.

## Fonctionnalités

- **Routing**: Gestion des routes GET et POST avec des callbacks ou des contrôleurs.
- **Request & Response**: Gestion des requêtes et réponses HTTP.
- **Dependency Injection**: Conteneur d'injection de dépendances pour une meilleure gestion des dépendances.
- **Views**: Système de vues pour la génération de contenu HTML.
- **Environment Configuration**: Gestion des variables d'environnement.
- **Error Handling**: Gestion des erreurs avec Whoops pour un mode debug convivial.

## Prérequis

- PHP 8.2 et supérieur
- Composer

## Installation

1. Clonez le dépôt:

    ```bash
    git clone [https://github.com/NARIHY/Projet-Copi-Colle-Laravel.git]
    ```

2. Accédez au répertoire du projet:

    ```bash
    cd miniframework-php
    ```

3. Installez les dépendances:

    ```bash
    composer install
    ```

4. Configurez les variables d'environnement:

    Copiez le fichier `.env.example` en `.env` et modifiez les valeurs selon votre configuration.

    ```bash
    cp .env.example .env
    ```

## Utilisation

### Structure du Projet qui permet de fonctionner l'application

```
app/
|
|--------Form/
|--------Http/
|--------Model/
|--------View/
|
src/
│
├── Aplication/
│   ├── Container.php
│   ├── Environement/
│   ├── Http/
│   ├── Router/
│   └── Views/
│
├── Security/
│   └── Application/
│
public/
│   └── index.php
│
config/
│   └── config.php
│
views/
│   └── 404.php
│
.env.example
composer.json
