<?php
require 'vendor/autoload.php';

use Src\Functions\MyFunction;
use Src\Terminale\ClassGenerator;

function ajouter_element_tableau($tableau_base, $new_tab) {
    return array_push($tableau_base, $new_tab);
}
//Instanciena ilay ensemble ana function ako sous forme methode
try {
    $trm = new MyFunction();
    //Ensuite alony eto
    $className = $trm->read("Entrer le nom du formulaire: ");
    //test
    $cls = new ClassGenerator($className);
    //$cls->generate_formulaire();
    $tableau = [];
    //anampidirana element vao2 ao anatiny io solaitra io
    do {
        $label = $trm->read("Entrer le label de votre champ: ");
        $name = $trm->read("Entrer le nom de votre champ: ");
        $type = $trm->read("Entrer le type de votre champ: ");
        $new_tab = [
            'label' => $label,
            'name' => $name,
            'type' => $type
        ];
        $tableau[] = $new_tab;
        $end = $trm->read("Est ce que vous avez entrer tous les éléments de votre formulaire? (o or n)");
    }while(strtolower($end) === "o");
    //Creation de la class form
    $cls->generate_formulaire($tableau);
    //Message de succès
    echo "\033[0;32m Votre formulaire $className a été créer avec succès!!";
    echo "\033[0m";
} catch(\Exception $e) {
    echo "\033[0;31m Il y a eu une erreur: " . $e->getMessage();
}

