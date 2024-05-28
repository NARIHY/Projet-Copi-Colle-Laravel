<?php 
namespace Src\Html;

/**
 * Class Form
 *
 * Classe pour gérer la génération de formulaires HTML.
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 NARIHY
 * @package Src\Html
 */
class Form 
{
    /**
     * @var array $donner Données des champs du formulaire
     */
    private array $donner;

    /**
     * @var string $btn Texte du bouton de soumission
     */
    private string $btn;

    /**
     * Form constructor.
     *
     * @param array $donner Données des champs
     * @param string $btn Texte du bouton
     */
    public function __construct(array $donner, string $btn) 
    {
        $this->donner = $donner;
        $this->btn = $btn;
    }

    /**
     * Génère un formulaire POST.
     *
     * @param string $nomFormulaire Nom du formulaire
     * @return void
     */
    public function formulaire_post(string $nomFormulaire): void
    {
        echo "<div class=\"container\">";
        echo "<form action=\"\" method=\"post\">";   
        echo "<h1 class=\"text-center\"> $nomFormulaire </h1>";
        foreach($this->donner as $d => $e) {
            $name = $e['name'];
            $label = $e['label'];
            $type = $e['type'];          
            echo "<label for=\"$name\">$label</label>";
            echo " <input type=\"$type\"  class=\"form-control\" name=\"$name\">";            
        }
        echo "<input type=\"submit\" style=\"margin-top:10px;width:100%\" class=\"btn btn-primary\" value=\" $this->btn\">";
        echo "</form>";
        echo "</div>";
    }

    /**
     * Génère un formulaire GET.
     * @param string $nomFormulaire nom du formulaire
     * @return void
     */
    public function formulaire_get(string $nomFormulaire): void
    {
        echo "<div class=\"container\">";
        echo "<form action=\"\" method=\"get\">";  
        echo "<h1 class=\"text-center\"> $nomFormulaire </h1>";        
        foreach($this->donner as $d => $e) {
            $name = $e['name'];
            $label = $e['label'];
            $type = $e['type'];          
            echo "<label for=\"$name\">$label</label>";
            echo " <input type=\"$type\"  class=\"form-control\" name=\"$name\">";            
        }
        echo "<input type=\"submit\" style=\"margin-top:10px;width:100%\" class=\"btn btn-primary\" value=\" $this->btn\">";
        echo "</form>";
        echo "</div>";
    }
}
