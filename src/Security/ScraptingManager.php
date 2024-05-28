<?php

namespace Src\Security;

/**
 * Class ScrapingManager
 *
 * Classe de base pour  scrapting test
 * 
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024
 * @package Src\Security
 */
class ScrapingManager
{
    private $allowedBots = [
        'Googlebot', 'Bingbot', 'Slurp', 'DuckDuckBot', 'Baiduspider', 'YandexBot', 'Sogou'
    ];

    public function __construct()
    {
        session_start();
    }

    /**
     * Vérifie si l'utilisateur est un bot en utilisant le User-Agent
     */
    public function checkUserAgent()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        foreach ($this->allowedBots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                $this->logRequest('bot');
                return true;
            }
        }

        $this->logRequest('human');
        return false;
    }

    /**
     * Journalise la requête avec des détails
     */
    private function logRequest($type)
    {
        $log = sprintf(
            "[%s] %s: %s %s\n",
            date('Y-m-d H:i:s'),
            strtoupper($type),
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['REQUEST_URI']
        );
        file_put_contents(__DIR__ . '/scraping.log', $log, FILE_APPEND);
    }

    /**
     * Traite la réponse pour les bots
     *
     * @param array $data Les données à retourner
     * @return string Les données formatées pour le bot
     */
    public function processBotResponse(array $data): string
    {
        return json_encode($data);
    }

    /**
     * Traite la réponse pour les utilisateurs humains
     *
     * @param array $data Les données à retourner
     * @return string Les données formatées pour l'utilisateur
     */
    public function processHumanResponse(array $data): string
    {
        return "<html><body>" . htmlspecialchars(json_encode($data)) . "</body></html>";
    }

    /**
     * Gère la requête en fonction de l'utilisateur (bot ou humain)
     *
     * @param array $data Les données à retourner
     * @return string La réponse formatée
     */
    public function handleRequest(array $data): string
    {
        if ($this->checkUserAgent()) {
            return $this->processBotResponse($data);
        } else {
            return $this->processHumanResponse($data);
        }
    }
}

// $data = [
//     'name' => 'Example',
//     'description' => 'This is an example data set.'
// ];
// $scrapingManager = new ScrapingManager();
// $response = $scrapingManager->handleRequest($data);
// echo $response;
