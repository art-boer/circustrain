<?php
declare(strict_types=1);

namespace Circustrein\Model;

class Wagon
{
    private array $animals = [];

    private ?Animal $carnivore = null;

    private int $spaceLeft = 10;

    public function addAnimal(Animal $animal): void
    {
        $this->spaceLeft -= $animal->getSpace();
        array_push($this->animals, $animal);

        if ($animal->getDiet() === 'Carnivore') {
            $this->carnivore = $animal;
        }
    }

    public function getAnimals(): array
    {
        return $this->animals;
    }

    public function getSpaceLeft(): int
    {
        return $this->spaceLeft;
    }

    public function getCarnivore(): Animal
    {
        return $this->carnivore;
    }

    public function hasCarnivore(): bool
    {
        return !empty($this->carnivore);
    }
}
