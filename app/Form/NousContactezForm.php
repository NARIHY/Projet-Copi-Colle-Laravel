<?php

namespace App\Form;

use Src\Form\BaseForm;

class NousContactezForm extends BaseForm
{
    public function element()
    {
        return [
            '0' => [
                'label' => 'Entrer votre nom:',
                'name' => 'nom',
                'type' => 'text',
            ],
            '1' => [
                'label' => 'Entrer votre prenon:',
                'name' => 'prenon',
                'type' => 'text',
            ],
            '2' => [
                'label' => 'Sujet de conversation',
                'name' => 'sujet',
                'type' => 'text',
            ],
            '3' => [
                'label' => 'Message',
                'name' => 'message',
                'type' => 'text',
            ],
        ];
    }

    public function generate_form()                                     
    {                                                                   
        $this->setBtn("Enregistrer");                                   
        $this->setProperty($this->element());                              
        $this->setNomFormulaire("Nous contacter");                     
        $this->generate_form_post();                                    
    } 

}
