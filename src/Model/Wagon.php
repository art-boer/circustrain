<?php
declare(strict_types=1);

namespace Circustrein\Model;

class Wagon
{
    private array $animals = [];

    private ?Animal $hasCarnivore = null;

    private int $spaceLeft = 10;

    public function addAnimal(Animal $animal): void
    {
        $this->spaceLeft -= $animal->getSpace();
        array_push($this->animals, $animal);
    }

    public function getAnimals(): array
    {
        return $this->animals;
    }

    public function getSpaceLeft(): int
    {
        return $this->spaceLeft;
    }

    public function setHasCarnivore(Animal $animal): void
    {
        if ($animal->getDiet() !== 'Carnivore') {
            throw new \Exception('Error: Tried to set non-carnivore as carnivore.');
        }

        $this->hasCarnivore = $animal;
    }

    public function hasCarnivore(): ?Animal
    {
        return $this->hasCarnivore;
    }
}
