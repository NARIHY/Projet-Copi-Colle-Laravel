1) Utilisation de scrapting

// Utilisation de la classe
$data = [
    'name' => 'Example',
    'description' => 'This is an example data set.'
];

$scrapingManager = new ScrapingManager();
$response = $scrapingManager->handleRequest($data);
echo $response;

2) Utilisation d'anti scrapting

$antiScraping = new AntiScraping();
$antiScraping->checkUserAgent();
$antiScraping->rateLimit();
$antiScraping->detectAnomalousBehavior();
$antiScraping->checkHoneypot();
$antiScraping->checkReferer();