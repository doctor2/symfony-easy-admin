<?php

namespace App\Domain\Zoo;

use App\Domain\Zoo\Animals\Animal;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class Cage
{
    private $animals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public function getAnimals(): ArrayCollection
    {
        return $this->animals;
    }

    public function getAnimal(int $number): ?Animal
    {
        return $this->animals->get($number);
    }

    public function addAnimal(Animal $animal): self
    {
        $this->assertSupportAnimalType($animal);

        $this->animals->add($animal);

        return $this;
    }

    public function removeAnimal(Animal $animal): bool
    {
        return $this->animals->removeElement($animal);
    }

    public function clean(): bool
    {
        if (!$this->animals->isEmpty()) {
            throw new Exception('Dangerous! Animal in the cage!');
        }

        $this->animals->clear();

        return true;
    }

    private function assertSupportAnimalType(Animal $animal): void
    {
        if (!$this->animals->isEmpty() && (string) $this->animals->last() != (string) $animal) {
            throw new Exception('Wrong kind of animal! Needs ' . (string) $this->animals->last());
        }
    }
}
