<?php

namespace Src\Aplication\Router;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Src\Aplication\Container;
use Src\Aplication\Debug\Debuger;

/**
 * Permet de gérer la route de base.
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 NARIHY 
 */
class Router
{
    /**
     * Tableau de routes enregistrées.
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Conteneur d'injection de dépendance.
     *
     * @var Container
     */
    private Container $container;

    /**
     * Constructeur de la classe Router.
     *
     * @param Container $container Conteneur d'injection de dépendance.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Enregistre une route GET.
     *
     * @param string $path Chemin de la route.
     * @param callable|string|array $callback Fonction de rappel à exécuter.
     * @param string $name Nom de la route (facultatif).
     * @return void
     */
    public function get(string $path, callable|string|array $callback, string $name = "")
    {
        $this->addRoute('get', $path, $callback);
        Debuger::dump($this->saveRoute('get', $path, $callback, $name));
    }

    /**
     * Enregistre une route POST.
     *
     * @param string $path Chemin de la route.
     * @param callable|string|array $callback Fonction de rappel à exécuter.
     * @param string $name Nom de la route (facultatif).
     * @return void
     */
    public function post(string $path, callable|string|array $callback, string $name = "")
    {
        $this->addRoute('post', $path, $callback);
    }

    /**
     * Ajoute une route au tableau des routes.
     *
     * @param string $method Méthode HTTP (GET, POST, etc.).
     * @param string $path Chemin de la route.
     * @param callable|string|array $callback Fonction de rappel à exécuter.
     * @return void
     */
    private function addRoute(string $method, string $path, callable|string|array $callback)
    {
        $this->routes[$method][$path] = $callback;
    }

    /**
     * Résout la route en fonction du chemin et de la méthode.
     *
     * @param string $path Chemin de la route.
     * @param string $method Méthode HTTP (GET, POST, etc.).
     * @return callable|string|array|false La fonction de rappel ou false si la route n'est pas trouvée.
     */
    public function resolve(string $path, string $method)
    {
        $callback = $this->routes[strtolower($method)][$path] ?? false;
        return $callback;
    }

    /**
     * Dispatch la requête et la réponse à travers le routeur.
     *
     * @param \Psr\Http\Message\ResponseInterface $request Requête HTTP.
     * @param \Psr\Http\Message\ResponseInterface $response Réponse HTTP.
     * @return mixed
     */
    public function dispatch(RequestInterface $request, ResponseInterface $response)
    {
        $path = $request->getUri()->getPath();
        $method = strtolower($request->getMethod());

        $callback = $this->resolve($path, $method);

        if ($callback) {
            return $this->executeCallback($callback, [$request, $response]);
        }

        $response->getBody()->write('Not Found');
        return $response->withStatus(404);
    }

    /**
     * Exécute la fonction de rappel pour une route.
     *
     * @param callable|string|array $callback Fonction de rappel à exécuter.
     * @param array $params Paramètres à passer à la fonction de rappel.
     * @return mixed
     */
    public function executeCallback(callable|string|array $callback, array $params)
    {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $params);
        }

        if (is_array($callback)) {
            $controller = $callback[0];
            $method = $callback[1];

            // Utiliser le conteneur pour instancier le contrôleur
            $controllerInstance = $this->container->make($controller);

            return call_user_func_array([$controllerInstance, $method], $params);
        }

        if (is_string($callback)) {
            return $this->executeControllerAction($callback);
        }

        throw new \Exception('Invalid callback');
    }

    //Todo later
    public function saveRoute(string $method, string $path, callable|string|array $callback, string $name = ""): array
    {
        $arrayRoute = [];
        $r = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'name' => $name
        ];
        array_push($arrayRoute,$r);
        return $arrayRoute;
    }
    /**
     * Exécute une action de contrôleur.
     *
     * @param string $callback Callback sous forme de chaîne "Controller@method".
     * @return mixed
     */
    private function executeControllerAction(string $callback)
    {
        list($controller, $method) = explode('@', $callback);
        $controller = "App\\Http\\Controller\\$controller";

        if (!class_exists($controller)) {
            throw new \Exception("Controller $controller not found");
        }

        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Method $method not found in controller $controller");
        }

        return call_user_func_array([$controllerInstance, $method], $this->params);
    }
}
