<?php

namespace Src\Aplication\Debug;

use Symfony\Component\VarDumper\VarDumper;

/**
 * Pour debuger notre application
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 NARIHY
 */
class Debuger 
{
    /**
     * Affiche les informations de débogage sur une variable
     * 
     * @param mixed $variable La variable à déboguer
     * @return void
     */
    public static function dump($variable)
    {
        VarDumper::dump($variable);
    }

    /**
     * Affiche les informations de débogage sur une variable puis arrête l'exécution du script
     * 
     * @param mixed $variable La variable à déboguer
     * @return void
     */
    public static function dd($variable)
    {
        VarDumper::dump($variable);
        die();
    }
}
