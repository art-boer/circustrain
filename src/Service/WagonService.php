<?php
declare(strict_types=1);

namespace Circustrein\Service;

use Circustrein\Model\Animal;
use Circustrein\Model\Wagon;

class WagonService
{
    public function createWagon(): Wagon
    {
        return new Wagon();
    }

    public function herbivoreAllowedInWagon(Animal $herbivore, Wagon $wagon): bool
    {
        return !$wagon->hasCarnivore() || $wagon->getCarnivore()->getSpace() < $herbivore->getSpace();
    }

    public function animalFitsInWagon(Animal $animal, Wagon $wagon): bool
    {
        return ($wagon->getSpaceLeft() - $animal->getSpace()) >= 0;
    }
}
