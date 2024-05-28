<?php 

namespace Src\Functions;

class MyFunction 
{
    /**
     * Ilaina mba tsy ho lava be eo amilay mirecuperer ny zavtra nosoratany utilisateur
     */
    public function read(string $prompt) 
    {
        echo $prompt;
        $line = trim(fgets(STDIN));
        return $line;
    }
}