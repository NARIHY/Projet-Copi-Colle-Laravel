<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Aplication\Container;
use Doctrine\DBAL\Connection;

class DoctrineConnectionTest extends TestCase
{
    private Container $container;

    // Cette méthode est exécutée avant chaque test
    protected function setUp(): void
    {
        // Initialisation du container
        $this->container = new Container();
    }

    // Test pour vérifier la connexion à la base de données via Doctrine ORM
     // Test pour vérifier la connexion à la base de données via Doctrine ORM
     public function testDoctrineConnection(): void
    {
        // Créer un EntityManager via le container
        $entityManager = $this->container->createDoctrineEntityManager();

        try {
            echo "Test de Doctrine ORM...\n";
            // Obtenez la connexion à partir de l'EntityManager
            $conn = $entityManager->getConnection();

            // Debug pour vérifier la configuration de la connexion
            echo "Paramètres de la connexion : " . json_encode($conn->getParams()) . "\n";

            // Vérifiez si la connexion est établie
            if ($conn->isConnected()) {
                echo "Connexion réussie à la base de données !\n";
                $this->assertTrue(true); // Connexion réussie
            } else {
                $this->fail("Échec de la connexion à la base de données.");
            }
        } catch (\Exception $e) {
            // Si une exception se produit, échouons le test et affichons l'erreur
            $this->fail("Erreur de connexion : " . $e->getMessage());
        }
    }
}
