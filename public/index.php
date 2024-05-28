<?php

use App\Http\Controller\HomeController;
use Src\Aplication\Application;
use Src\Security\Application\VerifyEnvironementSecurity;

// Charger l'autoloader de Composer
require '../vendor/autoload.php';

// Charger le fichier de configuration
$config = require '../config/config.php';


// Créer une instance de l'application avec la configuration
$application = new Application($config);

//DEbuging

$debuger = new VerifyEnvironementSecurity();

// Enregistrer les routes
$application->router->get('/', [HomeController::class, 'index'], "Acceuil");
$application->router->post('/',[HomeController::class, 'post_test'], "Post");
$application->router->get('/about', [HomeController::class, 'propos'], "Propos");




// Lancer l'application
$application->run();


