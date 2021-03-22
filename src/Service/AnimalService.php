<?php
declare(strict_types=1);

namespace Circustrein\Service;

use Circustrein\Model\Animal;
use Circustrein\Model\Wagon;

class AnimalService
{
    private array $herbivores;

    private array $carnivores;

    private WagonService $wagonService;

    public function __construct(WagonService $wagonService)
    {
        $this->wagonService = $wagonService;
    }

    public function setAnimals(array $animals): void
    {
        $this->filterAnimalTypes($animals);
        usort($this->herbivores, fn($a, $b) => strcmp($a->getSize(), $b->getSize()));
        usort($this->carnivores, fn($a, $b) => strcmp($a->getSize(), $b->getSize()));
    }

    public function addBiggestCarnivoreToWagon(Wagon $wagon): void
    {
        $wagon->addAnimal(array_shift($this->carnivores));
    }

    public function addHerbivoresToWagon(Wagon $wagon): void
    {
        foreach ($this->herbivores as $key => $herbivore) {
            if (!$this->wagonService->herbivoreAllowedInWagon($herbivore, $wagon)) {
                break;
            }

            if (!$this->wagonService->animalFitsInWagon($herbivore, $wagon)) {
                continue;
            }

            $wagon->addAnimal($herbivore);
            unset($this->herbivores[$key]);
        }
    }

    public function hasCarnivores(): bool
    {
        return !empty($this->carnivores);
    }

    public function hasHerbivores(): bool
    {
        return !empty($this->herbivores);
    }

    public function hasAnimals(): bool
    {
        return !empty($this->herbivores) && !empty($this->carnivores);
    }

    private function filterAnimalTypes(array $animals): void
    {
        $this->herbivores = array_filter($animals, function($animal) {
            return ($animal->getDiet() === 'Herbivore');
        });

        $this->carnivores = array_filter($animals, function($animal) {
            return ($animal->getDiet() === 'Carnivore');
        });
    }
}
