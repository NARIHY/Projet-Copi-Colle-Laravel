<?php

namespace App\Http\Controller;

use Src\Aplication\Debug\Debuger;
use Src\Aplication\Http\Controller\BaseController;

class HomeController extends BaseController
{

    /**
     * Permet de gerer l'acceuil
     */
    public function index()
    {
        $body = "Bonjour John Doe";
        $envVars = [
            'APP_NAME' => getenv('APP_NAME'),
            'APP_ENV' => getenv('APP_ENV'),
            'DB_HOST' => getenv('DB_HOST'),
            'DB_USER' => getenv('DB_USER')
        ];
        $params = [
            'titre' => 'Acceuil',
            'body' => $body,
            'env' => $envVars
        ];
        return $this->renders('home', $params);
    }

    public function post_test()
    {
        Debuger::dd($_POST);
    }
    public function propos()
    {
        $params = [
            'titre' => 'Propos',
            'body' => 'Propos du site'
        ];
        return $this->renders('propos', $params);
    }
}