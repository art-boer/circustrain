<?php
declare(strict_types=1);

namespace Circustrein\Builder;

use Circustrein\Model\Wagon;
use Circustrein\Model\Animal;

class TrainBuilder
{
    private array $animals;

    private array $herbivores;

    private array $carnivores;

    private array $train = [];

    private ?Wagon $currentWagon = null;

    public function __construct(array $animals) {
        $this->animals = $animals;
        $this->setupTrain();
    }

    public function getTrain(): array
    {
        return $this->train;
    }

    private function setupTrain(): void
    {
        $this->filterAnimalTypes($this->animals);

        //Sort herbivores and carnivores into size
        usort($this->herbivores, fn($a, $b) => strcmp($a->getSize(), $b->getSize()));
        usort($this->carnivores, fn($a, $b) => strcmp($a->getSize(), $b->getSize()));

        $this->fitAnimalsIntoWagons();
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

    private function fitAnimalsIntoWagons()
    {
        //Run out of animals
        if (!$this->carnivores && !$this->herbivores) {
            return;
        }

        //Old wagon was full so a new one needs to be created
        if (!$this->currentWagon) {
            $this->currentWagon = new Wagon();
        }

        //Can place carnivores?
        if (!$this->currentWagon->hasCarnivore()) {
            $this->placeBiggestCarnivore();
        }

        //Can place herbivores?
        if ($this->herbivores) {
            $this->placeBiggestHerbivore();
        }

        $this->addCurrentWagonToTrain();
        $this->fitAnimalsIntoWagons();
    }

    private function addCurrentWagonToTrain(): void
    {
        array_push($this->train, $this->currentWagon);
        $this->currentWagon = null;
    }

    private function placeBiggestCarnivore(): void
    {
        if (empty($this->carnivores)) {
            return;
        }

        $this->currentWagon->addAnimal($this->carnivores[0]);
        $this->currentWagon->setHasCarnivore($this->carnivores[0]);
        array_shift($this->carnivores);
    }

    private function placeBiggestHerbivore(): void
    {
        if (empty($this->herbivores)) {
            return;
        }

        $hasCarnivore = $this->currentWagon->hasCarnivore();

        foreach ($this->herbivores as $key => $herbivore) {
            if ($hasCarnivore && $hasCarnivore->getSize() >= $herbivore->getSize()) {
                break;
            }

            if (!$this->canFitInWagon($herbivore)) {
                continue;
            }

            $this->currentWagon->addAnimal($herbivore);
            unset($this->herbivores[$key]);
        }
    }

    private function canFitInWagon(Animal $animal): bool
    {
        $wagonSpaceLeft = $this->currentWagon->getSpaceLeft();

        return ($wagonSpaceLeft - $animal->getSpace()) >= 0;
    }
}
