<?php

namespace Src\Security;

/**
 * Class AntiScrapting
 *
 * Classe de base pour bloker le scrapting
 * 
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024
 * @package Src\Security
 */
class AntiScraping
{
    private $rateLimit = 100; // Nombre de requêtes permis
    private $timeWindow = 60; // En secondes
    private $botList = [
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
        foreach ($this->botList as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                header('HTTP/1.0 403 Forbidden');
                exit('Bot detected.');
            }
        }
    }

    /**
     * Limite le taux de requêtes pour chaque adresse IP
     */
    public function rateLimit()
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        if (!isset($_SESSION['rate_limit'])) {
            $_SESSION['rate_limit'] = [];
        }

        if (!isset($_SESSION['rate_limit'][$ip])) {
            $_SESSION['rate_limit'][$ip] = [];
        }

        $_SESSION['rate_limit'][$ip][] = time();

        $requests = array_filter($_SESSION['rate_limit'][$ip], function($timestamp) {
            return $timestamp > (time() - $this->timeWindow);
        });

        if (count($requests) > $this->rateLimit) {
            header('HTTP/1.0 429 Too Many Requests');
            exit('Rate limit exceeded.');
        }
    }

    /**
     * Affiche un CAPTCHA pour vérifier que l'utilisateur est humain
     */
    public function renderCaptcha()
    {
        echo '<form action="verify.php" method="post">
                <div class="g-recaptcha" data-sitekey="your_site_key"></div>
                <input type="submit" value="Submit">
              </form>';
    }

    /**
     * Obfuscation des données pour les rendre difficiles à extraire par des bots
     */
    public function obfuscateData($data)
    {
        return base64_encode($data);
    }

    /**
     * Détecte les comportements anormaux basés sur les modèles de requêtes
     */
    public function detectAnomalousBehavior()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $path = $_SERVER['REQUEST_URI'];

        // Log the request (implementation not shown)
        $this->logRequest($ip, $path);

        if ($this->isScrapingPatternDetected($ip)) {
            header('HTTP/1.0 403 Forbidden');
            exit('Anomalous behavior detected.');
        }
    }

    private function logRequest($ip, $path)
    {
        // Log the request to a database or file (implementation not shown)
    }

    private function isScrapingPatternDetected($ip)
    {
        // Analyze the logs for patterns indicative of scraping (implementation not shown)
        // Return true if a pattern is detected, otherwise false
        return false;
    }

    /**
     * Vérifie si le champ honeypot est rempli, indiquant un bot
     */
    public function checkHoneypot()
    {
        if (!empty($_POST['honeypot'])) {
            header('HTTP/1.0 403 Forbidden');
            exit('Honeypot detected.');
        }
    }

    /**
     * Vérifie la source de la requête en utilisant l'en-tête HTTP Referer
     */
    public function checkReferer()
    {
        if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], 'yourdomain.com') === false) {
            header('HTTP/1.0 403 Forbidden');
            exit('Invalid referer.');
        }
    }
}
