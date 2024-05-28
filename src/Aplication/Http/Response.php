<?php 

namespace Src\Aplication\Http;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Recupération des réponses HTTP
 * @autor RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 NARIHY
 */
class Response 
{
    private ResponseInterface $response;

    public function __construct()
    {
        $this->response = new GuzzleResponse();
    }

    /**
     * Set status http code
     * exemple 300
     * @param int $code code a envoyer
     * @return void
     */
    public function setStatusCode(int $code): void
    {
        $this->response = $this->response->withStatus($code);
    }

    /**
     * Ajouter un en-tête à la réponse
     * @param string $name
     * @param string $value
     * @return void
     */
    public function addHeader(string $name, string $value): void
    {
        $this->response = $this->response->withHeader($name, $value);
    }

    /**
     * Envoyer le corps de la réponse
     * @param string $body
     * @return void
     */
    public function setBody(string $body): void
    {
        $this->response = $this->response->withBody(\GuzzleHttp\Psr7\Utils::streamFor($body));
    }

    /**
     * Envoyer la réponse HTTP
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->response->getStatusCode());

        foreach ($this->response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }

        echo $this->response->getBody();
    }

    /**
     * Récupération de l'instance de la réponse PSR-7
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
