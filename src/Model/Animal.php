<?php
declare(strict_types=1);

namespace Circustrein\Model;

class Animal
{
    private string $size;

    private string $diet;

    public function __construct(
        string $size,
        string $diet
    ) {
        $this->size = $size;
        $this->diet = $diet;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getDiet(): string
    {
        return $this->diet;
    }

    public function getSpace(): int
    {
        switch($this->getSize()) {
            case 'Big':
                return 5;
            case 'Medium':
                return 3;
            case 'Small':
                return 1;
            default:
                throw new \Exception('Error: Tried to add unknown animal size to wagon.');
        }
    }
}
