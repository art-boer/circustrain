<?php
declare(strict_types=1);

namespace Circustrein\Builder;

use Circustrein\Service\AnimalService;
use Circustrein\Service\WagonService;

class TrainBuilder
{
    private AnimalService $animalService;

    private WagonService $wagonService;

    private array $train = [];

    public function __construct(
        AnimalService $animalService,
        WagonService $wagonService
    ) {
        $this->animalService = $animalService;
        $this->wagonService = $wagonService;
    }

    public function buildTrain(array $animals): void
    {
        $this->animalService->setAnimals($animals);
        $this->buildWagons();
    }

    public function getTrain(): array
    {
        return $this->train;
    }

    private function buildWagons()
    {
        if (!$this->animalService->hasAnimals()) {
            return;
        }

        $wagon = $this->wagonService->createWagon();

        if ($this->animalService->hasCarnivores()) {
            $this->animalService->addBiggestCarnivoreToWagon($wagon);
        }

        if ($this->animalService->hasHerbivores()) {
            $this->animalService->addHerbivoresToWagon($wagon);
        }

        array_push($this->train, $wagon);
        $this->buildWagons();
    }
}
