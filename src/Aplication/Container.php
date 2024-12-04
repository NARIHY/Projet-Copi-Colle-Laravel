<?php

namespace Src\Aplication;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Exception;
use ReflectionClass;
use ReflectionParameter;

/**
 * Le container d'injection de dépendances (DI Container)
 * pour gérer la gestion des dépendances, le découplage de notre application
 * et la réutilisation du code.
 */
class Container
{
    private array $bindings = [];
    private array $instances = [];

    /**
     * Enregistrer une classe ou une instance dans le conteneur.
     *
     * @param string $abstract
     * @param callable|string|null $concrete
     */
    public function bind(string $abstract, $concrete = null)
    {
        // Si aucune implémentation concrète n'est donnée, utilise l'abstract comme concrete
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        // Enregistre la liaison dans le conteneur
        $this->bindings[$abstract] = $concrete;
    }
    /**
     * Créer et configurer l'EntityManager Doctrine
     */
    public function createDoctrineEntityManager(): EntityManagerInterface
    {
        $isDevMode = true;
        // Chemin vers les entités et configuration
        $paths = [__DIR__ . "/../app/Model"];
        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

        // configuring the database connection
        $dbParams = DriverManager::getConnection([
            'driver'   => $_ENV['DB_DRIVER'],   // Exemple : pdo_mysql
            'host'     => $_ENV['DB_HOST'],    // Exemple : 127.0.0.1
            'port'     => $_ENV['DB_PORT'],    // Exemple : 3306
            'dbname'   => $_ENV['DB_DATABASE'], // Exemple : narihy
            'user'     => $_ENV['DB_USER'],    // Exemple : root
            'password' => $_ENV['DB_PASSWORD'] // Exemple : (vide)
        ], $config);
        // Création de l'EntityManager
        $entityManager = new EntityManager($dbParams, $config);

        $this->singleton(EntityManagerInterface::class, $entityManager);
        return  $this->instances[EntityManagerInterface::class];
    }
    /**
     * Enregistrer le gestionnaire d'entité Doctrine dans le conteneur
     */
    public function registerDoctrine(EntityManagerInterface $entityManager): void
    {
        $this->singleton(EntityManagerInterface::class, $entityManager);
    }

    /**
     * Enregistrer une instance partagée dans le conteneur.
     *
     * @param string $abstract
     * @param mixed $instance
     */
    public function singleton(string $abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }

    /**
     * Résoudre une dépendance.
     *
     * @param string $abstract
     * @return mixed
     * @throws Exception
     */
    public function make(string $abstract)
    {
        // Vérifie si une instance partagée existe
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // Vérifie si une classe ou un callback est enregistré
        if (!isset($this->bindings[$abstract])) {
            $concrete = $abstract;
        } else {
            $concrete = $this->bindings[$abstract];
        }

        // Résout l'instance
        if ($concrete instanceof \Closure) {
            // Si c'est un Closure, exécute-le avec le conteneur
            $object = $concrete($this);
        } else {
            // Sinon, crée l'instance via la méthode build()
            $object = $this->build($concrete);
        }

        // Si c'est un singleton, enregistre l'instance dans le conteneur
        if (!isset($this->instances[$abstract])) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    /**
     * Construire une instance de la classe donnée.
     *
     * @param string $concrete
     * @return mixed
     * @throws Exception
     */
    private function build(string $concrete)
    {
        // Récupère les métadonnées de la classe via Reflection
        $reflector = new ReflectionClass($concrete);

        // Vérifie si la classe est instanciable
        if (!$reflector->isInstantiable()) {
            throw new Exception("La classe $concrete n'est pas instanciable.");
        }

        // Récupère le constructeur de la classe
        $constructor = $reflector->getConstructor();

        // Si pas de constructeur, crée une nouvelle instance de la classe
        if (is_null($constructor)) {
            return new $concrete;
        }

        // Récupère les paramètres du constructeur
        $parameters = $constructor->getParameters();
        $dependencies = $this->resolveDependencies($parameters);

        // Crée l'instance avec les dépendances résolues
        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * Résoudre les dépendances du constructeur.
     *
     * @param array $parameters Les paramètres du constructeur de la classe
     * @return array Retourne un tableau des instances résolues des dépendances
     * @throws Exception Si une dépendance ne peut pas être résolue
     */
    private function resolveDependencies(array $parameters)
    {
        $dependencies = [];

        // Parcourt chaque paramètre du constructeur
        foreach ($parameters as $parameter) {
            // Obtient le type de la dépendance du paramètre
            $dependency = $parameter->getType();

            // Vérifie si le type de dépendance est non primitif et existe
            if ($dependency && !$dependency->isBuiltin()) {
                // Résout la dépendance et l'ajoute au tableau des dépendances
                $dependencies[] = $this->make($dependency->getName());
            } elseif ($parameter->isDefaultValueAvailable()) {
                // Si une valeur par défaut est disponible, l'ajoute
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                // Si la dépendance ne peut être résolue, lance une exception
                throw new Exception("Dépendance non résolue pour le paramètre {$parameter->getName()}.");
            }
        }

        return $dependencies;
    }
}
