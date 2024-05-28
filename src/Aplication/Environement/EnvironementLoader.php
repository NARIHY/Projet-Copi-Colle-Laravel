<?php 

namespace Src\Aplication\Environement;

class EnvironementLoader 
{
    private string $filePath;

    /**
     * Set the .env path to the class
     * @param string $filePath path to the .env
     */
    public function __construct()
    {
        $this->filePath= dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . ".env";       
    }   

    public function load(): void
    {
        if(!file_exists($this->filePath)) {
            throw new \Exception ("Environement introuvable: $this->filePath");
        }
        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
        foreach($lines as $line) {
            //Ignoree all coments
            if(strpos(trim($line), '#') === 0){
                continue;
            }

            //On parse de ligne par ligne
            list($name,$value) = explode('=', $line,2);
            $name = trim($name);
            $value = trim($value);


            //Remove surounding quotes if presents
            if(preg_match('/^["\'](.*)["\']$/', $value, $mathes)) {
                $value = $mathes[1];
            }
            if(!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                //Set enveronement variable
                putenv("$name=$value");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    } 
}