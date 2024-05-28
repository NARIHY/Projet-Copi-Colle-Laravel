<?php

namespace Src\Aplication;

use Src\Aplication\Environement\EnvironementLoader;
use Src\Aplication\Http\Request;
use Src\Aplication\Http\Response;
use Src\Aplication\Router\Router;
use Src\Aplication\Views\Vue;
use Src\Security\Application\VerifyEnvironementSecurity;
use Src\Aplication\Container;
use Src\Aplication\Debug\Debuger;

/** 
 * Permet de gérer notre application
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 NARIHY
 */
class Application 
{
    /** @var \Src\Aplication\Router\Router $router instance du routeur */
    public Router $router;
    /** @var \Src\Aplication\Http\Request $request instance des request */
    public Request $request;
    /** @var \Src\Aplication\Http\Response $response instance des response */
    public Response $response;
    /** @var \Src\Aplication\Views\Vue $view instance des vues */
    public Vue $view;
    /** @var array $config instance des fichier de configuration */
    public array $config;
    /** @var \Src\Aplication\Container $container instance d'un container */
    public Container $container;
    /** \Src\Security\Application\VerifyEnvironementSecurity $envSecurity verification d'un environement de sécurité */
    public VerifyEnvironementSecurity $envSecurity;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->container = new Container();
        $this->registerBindings();

        $this->router = $this->container->make(Router::class);
        $this->request = $this->container->make(Request::class);
        $this->view = $this->container->make(Vue::class);
        $this->response = $this->container->make(Response::class);

        $this->loadEnvironmentVariables();
        $this->envSecurity = $this->environementSecurity();
    }

    /**
     * Enregistrement des dépendances
     */
    private function registerBindings(): void
    {
        $this->container->singleton(Container::class, $this->container);
        $this->container->bind(Router::class);
        $this->container->bind(Request::class);
        $this->container->bind(Vue::class);
        $this->container->bind(Response::class);
    }

    /**
     * Lancer les variables d'environnement
     * @return void
     */
    public function loadEnvironmentVariables(): void
    {
        $envLoader = $this->container->make(EnvironementLoader::class);
        $envLoader->load();
    }

    /**
     * Verification de l'environnement de sécurité
     * @return \Src\Security\Application\VerifyEnvironementSecurity
     */
    public function environementSecurity(): VerifyEnvironementSecurity
    {
        $this->container->bind(VerifyEnvironementSecurity::class);
        $security = $this->container->make(VerifyEnvironementSecurity::class);
        return $security;
    }

    /**
     * Lancer notre application 
     * @return void
     */
    public function run(): void
    {
       // Debuger::dump($this->envSecurity->verification__app());
        try {
            $route = $this->router->resolve($this->request->getPath(), $this->request->getMethod());
            if ($route) {
                echo $this->router->executeCallback($route, [$this->request, $this->response]);
            } else {
                $this->response->setStatusCode(404);
                echo $this->view->render('404');
            }
        } catch (\Exception $e) {
            //Si il y en a une erreur
            if ($this->config['app']['debug'] === true) {
                $whoops = new \Whoops\Run;
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
                $whoops->register();
            } else {
                echo "An error occurred. Please try again later.";
            }
        }
    }
}
