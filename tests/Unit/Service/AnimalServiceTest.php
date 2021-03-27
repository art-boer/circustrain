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

    public function setUp(): void
    {
        $wagonService = $this->createMock(WagonService::class);

        $animals = [
            new Animal('Big', 'Carnivore'),
            new Animal('Big', 'Herbivore'),
        ];

        $this->animalService = new AnimalService($wagonService);
        $this->animalService->setAnimals($animals);
    }

    public function testHasCarnivores(): void
    {
        $hasCarnivores = $this->animalService->hasCarnivores();

        $this->assertTrue($hasCarnivores);
    }

    public function testHasNoCarnivores(): void
    {
        $this->animalService->setAnimals([]);
        $hasCarnivores = $this->animalService->hasCarnivores();

        $this->assertFalse($hasCarnivores);
    }

    public function testHasHerbivores(): void
    {
        $hasHerbivores = $this->animalService->hasHerbivores();

        $this->assertTrue($hasHerbivores);
    }

    public function testHasNoHerbivores(): void
    {
        $this->animalService->setAnimals([]);
        $hasHerbivores = $this->animalService->hasHerbivores();

        $this->assertFalse($hasHerbivores);
    }

    public function testHasAnimals(): void
    {
        $hasAnimals = $this->animalService->hasAnimals();

        $this->assertTrue($hasAnimals);
    }

    public function testHasNoAnimals(): void
    {
        $this->animalService->setAnimals([]);
        $hasAnimals = $this->animalService->hasAnimals();

        $this->assertFalse($hasAnimals);
    }
}
