<?php

namespace App\Zoo;

use App\Zoo\Animals\Animal;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class Cage
{
    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    /**
     * @var ArrayCollection
     */
    private $animals;

    /**
     * @return ArrayCollection
     */
    public function getAnimals(): ArrayCollection
    {
        return $this->animals;
    }

    /**
     * @param int $number
     * @return Animal|null
     */
    public function getAnimal(int $number): ?Animal
    {
        return $this->animals[$number] ?? null;
    }

    /**
     * @param Animal $animal
     * @return $this
     * @throws Exception
     */
    public function addAnimal(Animal $animal): self
    {
        $this->checkAnimalType($animal);

        $this->animals->add($animal);

        return $this;
    }

    /**
     * @return Animal|null
     */
    public function removeAnimal(): ?Animal
    {
        if($this->animals->isEmpty()){
            return null;
        }

        if($animal = $this->animals->last()){
            $this->animals->removeElement($animal);
        }

        return $animal;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function clean()
    {
        if (!$this->animals->isEmpty()) {
            throw new Exception('Dangerous! Animal in the cage!');
        }

        $this->animals->clear();

        return 'Clear';
    }

    /**
     * @param Animal $animal
     * @throws Exception
     */
    protected function checkAnimalType(Animal $animal)
    {
        if (!$this->animals->isEmpty() && (string)$this->animals->last() != (string)$animal) {
            throw new Exception('Wrong kind of animal! ' . 'Needs ' . (string)$this->animals->last());
        }
    }

}