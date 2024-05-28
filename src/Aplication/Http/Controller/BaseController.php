<?php 
namespace Src\Aplication\Http\Controller;

use Src\Aplication\Views\Vue;

/**
 * Controller mère qui permet de gérer notre application
 * Pour permettre L'architecture MVC
 * @author RANDRIANARISOA
 * @copyright 2024 NARIHY
 */
class BaseController 
{
    protected Vue $vue;

    public function __construct()
    {
        $this->vue = new Vue();
    }

    /**
     * Render view
     * @param string $view c'est le chemin de la vue
     * @param array $params Ce sont les parametres a passer dans la vue
     * @return string le retour du vue
     */
    protected function renders(string $view, array $params): string
    {
        return $this->vue->render($view, $params);
    }
}