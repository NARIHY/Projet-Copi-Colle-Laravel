<?php 

namespace Src\Aplication\Http;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Recupération des requêtes HTTP
 * @autor RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 NARIHY
 */
class Request 
{
    private ServerRequestInterface $request;

    public function __construct()
    {
        $this->request = ServerRequest::fromGlobals();
    }

    /**
     * Recupération du chemin de l'url
     * @return string
     */
    public function getPath(): string
    {
        $uri = $this->request->getUri();
        $path = $uri->getPath();
        return '/' . trim($path, '/');
    }

    /**
     * Recupération de la méthode HTTP
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($this->request->getMethod());
    }

    /**
     * Récupération de l'instance de la requête PSR-7
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
