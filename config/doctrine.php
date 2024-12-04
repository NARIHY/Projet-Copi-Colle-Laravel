<?php
// config/doctrine.php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

// Configuration de la connexion à la base de données
$isDevMode = true;



// Chemin vers les entités et configuration
$paths = [__DIR__ . "/../app/Model"];
$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

// configuring the database connection
$connection = DriverManager::getConnection([
    'driver'   => $_ENV['DB_DRIVER'],   // Exemple : pdo_mysql
    'host'     => $_ENV['DB_HOST'],    // Exemple : 127.0.0.1
    'port'     => $_ENV['DB_PORT'],    // Exemple : 3306
    'dbname'   => $_ENV['DB_DATABASE'], // Exemple : narihy
    'user'     => $_ENV['DB_USER'],    // Exemple : root
    'password' => $_ENV['DB_PASSWORD'] // Exemple : (vide)
], $config);
// Création de l'EntityManager
$entityManager = new EntityManager($dbParams, $config);
