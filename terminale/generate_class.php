<?php
require 'vendor/autoload.php';

use Src\Functions\MyFunction;
use Src\Terminale\ClassGenerator;

$trm = new MyFunction();


$className = $trm->read("Entrer le nom de la class: ");
$namespace = $trm->read("Entrer son namespace: ");
$outputDirectory = $trm->read("Entrer son chemin: ");
//test
$cls = new ClassGenerator($className,"",$namespace,$outputDirectory);
$cls->generate();