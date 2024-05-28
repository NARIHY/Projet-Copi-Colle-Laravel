<?php 

namespace Src\Security\Application;

use Src\Aplication\Application;
use Src\Aplication\Debug\Debuger;
use Src\Aplication\Environement\EnvironementLoader;
use Whoops\Handler\CallbackHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Class qui permet de vérifier l'environement de base
 * Le nom de l'application 
 * le mode
 * etc
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 NARIHY
 */
class VerifyEnvironementSecurity 
{
    protected bool $debug;
    public function __construct()
    {
        $config = require dirname(__DIR__,3). DIRECTORY_SEPARATOR ."config".DIRECTORY_SEPARATOR ."config.php"; 
        $this->debug = $config['app']['debug'] ?? false;
        $this->register();
    }

    public function register():void 
    {
       

        if($this->debug) {
            $whoops = new Run();
            $whoops->pushHandler(new PrettyPageHandler());            
            $whoops->register();
        } else {
            http_response_code(500);
            echo "Il y a eu une erreur";
        }
    }
    
}