<?php
declare(strict_types=1);

use Circustrein\Builder\TrainBuilder;
use Circustrein\Model\Animal;
use PHPUnit\Framework\TestCase;

final class TrainBuilderTest extends TestCase
{
    private array $animals;

    private TrainBuilder $trainBuilder;

    public function setUp(): void
    {
        $this->animals = [
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
        ];

        shuffle($this->animals);

        $this->trainBuilder = new TrainBuilder($this->animals);
    }

    public function testCanFillTwelveWagons(): void
    {
        $this->assertCount(12, $this->trainBuilder->getTrain(), 'Train does not contain 12 wagons!');
    }

    public function testFirstWagonContainsCarnivore(): void
    {
        $firstWagon = $this->trainBuilder->getTrain()[0];
        $firstAnimal = $firstWagon->getAnimals()[0];
        $this->assertEquals('Carnivore', $firstAnimal->getDiet());
    }

    public function testLastWagonContainsThreeAnimals(): void
    {
        $train = $this->trainBuilder->getTrain();
        $lastWagon = end($train);

        $this->assertCount(3, $lastWagon->getAnimals(), 'Last wagon does not contain 3 animals!');
    }

    public function testLastWagonContainsThreeSmallHerbivores(): void
    {
        $train = $this->trainBuilder->getTrain();
        $lastWagon = end($train);

        foreach ($lastWagon->getAnimals() as $animal) {
            $this->assertEquals('Small', $animal->getSize());
            $this->assertEquals('Herbivore', $animal->getDiet());
        }
    }
}