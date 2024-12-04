<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Src\Aplication\Container;
use Doctrine\ORM\EntityManagerInterface;

class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    public function testContainerCanResolveDoctrineEntityManager(): void
    {
        // Enregistrer EntityManager comme singleton
        $entityManager = $this->container->createDoctrineEntityManager();
        $this->container->registerDoctrine($entityManager);

        // Vérifier que l'instance est bien résolue
        $resolvedEntityManager = $this->container->make(EntityManagerInterface::class);

        $this->assertInstanceOf(EntityManagerInterface::class, $resolvedEntityManager);
        $this->assertSame($entityManager, $resolvedEntityManager);
    }

    public function testDependencyInjectionWithBasicClasses(): void
    {
        // Ajouter une classe simple pour le test
        $this->container->bind(SomeClass::class);

        $instance = $this->container->make(SomeClass::class);

        $this->assertInstanceOf(SomeClass::class, $instance);
    }
}

class SomeClass
{
    // Classe simple pour test
}
