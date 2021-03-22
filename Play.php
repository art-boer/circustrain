<?php
declare(strict_types=1);

include('./vendor/autoload.php');

use Circustrein\Builder\TrainBuilder;
use Circustrein\Model\Animal;
use Circustrein\Service\AnimalService;
use Circustrein\Service\WagonService;

/**
 * Define some animals
 * 2 Big Carnivores
 * 3 Big Herbivores
 * 4 Medium Carnivores
 * 2 Medium Herbivores
 * 5 Small Carnivores
 * 3 Small Herbivores
 **/
$animals = array(
    new Animal('Big', 'Carnivore'),
    new Animal('Big', 'Carnivore'),
    new Animal('Big', 'Herbivore'),
    new Animal('Big', 'Herbivore'),
    new Animal('Big', 'Herbivore'),
    new Animal('Medium', 'Carnivore'),
    new Animal('Medium', 'Carnivore'),
    new Animal('Medium', 'Carnivore'),
    new Animal('Medium', 'Carnivore'),
    new Animal('Medium', 'Herbivore'),
    new Animal('Medium', 'Herbivore'),
    new Animal('Small', 'Carnivore'),
    new Animal('Small', 'Carnivore'),
    new Animal('Small', 'Carnivore'),
    new Animal('Small', 'Carnivore'),
    new Animal('Small', 'Carnivore'),
    new Animal('Small', 'Herbivore'),
    new Animal('Small', 'Herbivore'),
    new Animal('Small', 'Herbivore'),
);

$wagonService = new WagonService();
$animalService = new AnimalService($wagonService);

$trainBuilder = new TrainBuilder($animalService);
$trainBuilder->buildTrain($animals);

echo 'Totaal aantal wagons: ' . count($trainBuilder->getTrain());