<?php
declare(strict_types=1);

namespace Circustrein\Tests\Unit\Service;

use Circustrein\Model\Animal;
use Circustrein\Service\AnimalService;
use Circustrein\Service\WagonService;
use PHPUnit\Framework\TestCase;

final class AnimalServiceTest extends TestCase
{
    private AnimalService $animalService;

    private AnimalService $animalServiceWithoutAnimals;

    public function setUp(): void
    {
        $wagonService = $this->createMock(WagonService::class);

        $animals = [
            new Animal('Big', 'Carnivore'),
            new Animal('Big', 'Herbivore'),
        ];

        $this->animalService = new AnimalService($wagonService);
        $this->animalService->setAnimals($animals);

        $this->animalServiceWithoutAnimals = new AnimalService($wagonService);
    }

    public function testHasCarnivores(): void
    {
        $hasCarnivores = $this->animalService->hasCarnivores();

        $this->assertTrue($hasCarnivores);
    }

    public function testHasNoCarnivores(): void
    {
        $hasCarnivores = $this->animalServiceWithoutAnimals->hasCarnivores();

        $this->assertFalse($hasCarnivores);
    }

    public function testHasHerbivores(): void
    {
        $hasHerbivores = $this->animalService->hasHerbivores();

        $this->assertTrue($hasHerbivores);
    }

    public function testHasNoHerbivores(): void
    {
        $hasHerbivores = $this->animalServiceWithoutAnimals->hasHerbivores();

        $this->assertFalse($hasHerbivores);
    }

    public function testHasAnimals(): void
    {
        $hasAnimals = $this->animalService->hasAnimals();

        $this->assertTrue($hasAnimals);
    }

    public function testHasNoAnimals(): void
    {
        $hasAnimals = $this->animalServiceWithoutAnimals->hasAnimals();

        $this->assertFalse($hasAnimals);
    }
}
