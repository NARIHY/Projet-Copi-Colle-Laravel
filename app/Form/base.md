Manuel d'utilisation de notre classe qui etant de la base form

1) On instance d'abord notre class qu'on vient de recréer via notre terminale via la comande php terminale/formulaire.php
2) On remplis ensuite les information demander
3) Si vous êtes satisfait,entrer n 

4) pour afficher le formulaire vous devriez entrer ce script dans votre vue par exemple index.php
    ________________________________________________________________________
    | <?php                                                                |
    | require 'vendor/autoload.php';                                       |
    |use App\Form\TestForm;                                                |
    |                                                                      |
    |$test = new TestForm();                                               |
    |echo '<pre>';                                                         |
    |var_dump($test->test());                                              |
    |echo '</pre>';                                                        |
    |                                                                      |
    |$test->generate_form();                                               |
    |______________________________________________________________________|
 
5) Positionner vous maintenant dans la class du formulaire qui vient d'etre créer
    Dans notre exemple c'est TestForm.php et ajouter ce bout de code.
    -------------------------------------------------------------------------
    |   public function generate_form()                                     |
    |   {                                                                   |
    |       $this->setBtn("Enregistrer");                                   |
    |       $this->setProperty($this->test());                              |
    |       $this->setNomFormulaire("Test formulaire");                     |
    |       $this->generate_form_post();                                    | 
    |   }                                                                   |
    |-----------------------------------------------------------------------|