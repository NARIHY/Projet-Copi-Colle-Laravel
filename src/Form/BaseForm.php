<?php 
namespace Src\Form;

use Src\Html\Form;

/**
 * Class BaseForm
 *
 * Classe de base pour la gestion des formulaires.
 * 
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024
 * @package App\Form
 */
class BaseForm
{
    /**
     * @var array $property Propriétés du formulaire
     */
    protected array $property = [];

    /**
     * @var string $btn Texte du bouton de soumission
     */
    protected string $btn = "";

    /**
     * @var string $nomFormulaire Nom du formulaire
     */
    protected string $nomFormulaire = "";

    /**
     * Getters des propriétés du formulaire.
     *
     * @return array
     */
    protected function getProperty(): array
    {
        return $this->property;
    }

    /**
     * Setters des propriétés du formulaire.
     *
     * @param array $props Propriétés à définir
     * @return array
     */
    protected function setProperty(array $props): array
    {
        return $this->property = $props;
    }

    /**
     * Getters du bouton de soumission.
     *
     * @return string
     */
    protected function getBtn(): string 
    {
        return $this->btn;   
    }

    /**
     * Setters du bouton de soumission.
     *
     * @param string $btn Texte du bouton
     * @return string
     */
    protected function setBtn(string $btn): string 
    {
        return $this->btn = $btn;   
    }

    /**
     * Récupérer le nom du formulaire.
     *
     * @return string
     */
    protected function getNomFormulaire(): string
    {
        return $this->nomFormulaire;
    }

    /**
     * Setter le nom du formulaire.
     *
     * @param string $nomFormulaire Nom du formulaire
     * @return string
     */
    protected function setNomFormulaire(string $nomFormulaire): string
    {
        return $this->nomFormulaire = $nomFormulaire;
    }

    /**
     * Génère le formulaire POST.
     *
     * @return void
     */
    protected function generate_form_post()
    {
        $form = new Form($this->property, $this->btn);
        $form->formulaire_post($this->nomFormulaire);
    }
}
