<?php

namespace App\Zoo;

use App\Zoo\Animals\Animal;
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
        return $this->animals[$number] ?? null;
    }

    public function getLastAnimal(): ?Animal
    {
        $animal = $this->animals->last();

        return $animal === false ? null : $animal;
    }

    public function addAnimal(Animal $animal): self
    {
        $this->assertIsOneAnimalTypeInTheCage($animal);

        $this->animals->add($animal);

        return $this;
    }

    public function removeAnimal(): bool
    {
        if ($this->animals->isEmpty()) {
            return false;
        }

        return $this->animals->removeElement($this->animals->last());
    }

    public function clean(): bool
    {
        if (!$this->animals->isEmpty()) {
            throw new Exception('Dangerous! Animal in the cage!');
        }

        $this->animals->clear();

        return true;
    }

    private function assertIsOneAnimalTypeInTheCage(Animal $animal): void
    {
        if (!$this->animals->isEmpty() && (string) $this->animals->last() != (string) $animal) {
            throw new Exception('Wrong kind of animal! Needs ' . (string) $this->animals->last());
        }
    }
}
