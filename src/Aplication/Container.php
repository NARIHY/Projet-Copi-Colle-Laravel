<?php

namespace Src\Aplication;

use Exception;
use ReflectionClass;
use ReflectionParameter;
use Src\Aplication\Debug\Debuger;

/**
 * Le container d'injection d'indépedance (DI Container) 
 * pour gérer la gestion des dépendance
 * découplage de notre application
 * et aux réutilisation de mon code
 * 
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 */
class Container
{
    private array $bindings = [];
    private array $instances = [];

    /**
     * Enregistrer une classe ou une instance dans le conteneur
     *
     * @param string $abstract
     * @param callable|string|null $concrete
     */
    public function bind(string $abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Enregistrer une instance partagée dans le conteneur
     *
     * @param string $abstract
     * @param mixed $instance
     */
    public function singleton(string $abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }

    /**
     * Résoudre une dépendance
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
            $object = $concrete($this);
        } else {
            $object = $this->build($concrete);
        }

        return $object;
    }

    /**
     * Construire une instance de la classe donnée
     *
     * @param string $concrete
     * @return mixed
     * @throws Exception
     */
    private function build(string $concrete)
    {
        $reflector = new ReflectionClass($concrete);

        // Vérifie si la classe est instanciable
        if (!$reflector->isInstantiable()) {
            throw new Exception("Class $concrete is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        // Si pas de constructeur, retourne une nouvelle instance
        if (is_null($constructor)) {
            return new $concrete;
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->resolveDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * Résoudre les dépendances du constructeur
     *
     * @param array $parameters les parametre du constructeur de la class
     * @return array Retourne en tableau les instances résolue des dépandance
     * @throws Exception Si la dépandance ne peut pas être résolu
     */
    private function resolveDependencies(array $parameters)
    {
        $dependencies = [];
        //Parcour chaque partie du constructeur
        foreach ($parameters as $parameter) {
            //Obtient la types de dépendance du paramètre
            $dependency = $parameter->getType();
            //vérifie si le type de dépendance existe et n'est pas primitif
            if ($dependency && !$dependency->isBuiltin()) {
                //Résou la dépendance et ajout au tableau de dépendance
                $dependencies[] = $this->make($dependency->getName());
                
            } elseif ($parameter->isDefaultValueAvailable()) { //Verifie si une valeur par défaut est disponnible pour le parametre
                $dependencies[] = $parameter->getDefaultValue(); //utilise les valeur par défaut du parametre pour s'instancier
            } else {
                //Si il ne peut pas etre résoulu
                throw new Exception("Unresolvable dependency resolving [$parameter].");
            }
        }

        return $dependencies;
    }
}
