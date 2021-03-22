<?php
declare(strict_types=1);

namespace Circustrein\Tests\Integration;

use Circustrein\Builder\TrainBuilder;
use Circustrein\Model\Animal;
use Circustrein\Service\AnimalService;
use Circustrein\Service\WagonService;
use PHPUnit\Framework\TestCase;

final class TrainBuilderTest extends TestCase
{
    private TrainBuilder $trainBuilder;

    public function setUp(): void
    {
        $animals = [
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

        shuffle($animals);

        $wagonService = new WagonService();
        $animalService = new AnimalService($wagonService);
        $this->trainBuilder = new TrainBuilder($animalService, $wagonService);
        $this->trainBuilder->buildTrain($animals);
    }

    public function testAnimalsDontGetEatenInWagons(): void
    {
        $train = $this->trainBuilder->getTrain();

        foreach ($train as $wagon) {
            $this->assertGreaterThanOrEqual(0, $wagon->getSpaceLeft());

            if (!$wagon->hasCarnivore()) {
                continue;
            }

            $carnivore = $wagon->getCarnivore();

            foreach ($wagon->getAnimals() as $animal) {
                if ($animal === $carnivore) {
                    continue;
                }

                $this->assertGreaterThan($carnivore->getSpace(), $animal->getSpace());
            }
        }

        $this->assertCount(12, $train, 'Train does not contain 12 wagons!');
    }
}