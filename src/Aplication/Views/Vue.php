<?php

namespace Src\Aplication\Views;

/**
 * Permet de regenerer une vue
 * On devras pouvoir cabler ceci aux template blade
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 NARIHY
 * @package Src\Aplication\Views
 */
class Vue
{

    protected string $baseViewPath;

    /**
     * Constructeur pour setter le chemin de base pour la vue
     */
    public function __construct()
    {
        $this->baseViewPath = dirname(__DIR__,3).  DIRECTORY_SEPARATOR ."views".DIRECTORY_SEPARATOR;
    }
    /**
     * Rendre un fichier de vue
     * @param string $view le fichier de vue a rendre sans l'extension php
     * @param array $params les parametre a passer dans la vue
     * @return string Rendement du contenu de la vue
     * @throws \Exception si le fichier n'existe pas
     */
    public function render(string $view, array $params= [])
    {
        //Extraction des parametre vers le local variable
        foreach($params as $key => $value) {
            $key = $value;
        }
        //CHemin de vue de base a revenir en cas d'erreur
        $viewPath = $this->baseViewPath .$view.".php";
        
        //Construction du chemin reel
        //$viewPath = $this->baseViewPath. DIRECTORY_SEPARATOR . $view . '.php';

        //Check si le fichier existe
        if(!file_exists($viewPath)) {
            throw new \Exception("Le fichier vue: $viewPath n'a pas été trouver");
        }
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
}