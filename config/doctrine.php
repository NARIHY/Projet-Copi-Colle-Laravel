<?php
// config/doctrine.php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Configuration de la connexion à la base de données
$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => 'password',
    'dbname'   => 'nom_de_ta_base_de_donnees',
];

// Chemin vers les entités et configuration
$paths = [__DIR__ . "/../src/Model"];
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

// Création de l'EntityManager
$entityManager = EntityManager::create($dbParams, $config);
