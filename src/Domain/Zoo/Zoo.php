<?php

namespace App\Domain\Zoo;

use App\Domain\Zoo\Animals\Animal;
use App\Domain\Zoo\Animals\Crocodile;
use App\Domain\Zoo\Animals\Elephant;
use App\Domain\Zoo\Animals\Lien;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class Zoo
{
    private const ANIMAL_CLASSES = [
        'liens' => Lien::class,
        'crocodiles' => Crocodile::class,
        'elephants' => Elephant::class,
    ];

    /**
     * @var ArrayCollection
     */
    private $cages;

    /**
     * @var mixed[]
     */
    private $zooConfig;

    public function __construct(array $zooConfig)
    {
        $this->zooConfig = $zooConfig;

        $this->initZoo();
    }

    public function getCages(): ArrayCollection
    {
        return $this->cages;
    }

    public function getCage(int $number): ?Cage
    {
        return $this->cages->get($number);
    }

    public function cleanCage(int $number): string
    {
        /** @var Cage $cage */
        $cage = $this->cages->get($number);

        if (empty($cage)) {
            throw new Exception('Wrong cage number!');
        }

        $animals = $cage->getAnimals()->toArray();

        array_map(function (Animal $animal) use ($cage) {
            $cage->removeAnimal($animal);
        }, $animals);

        $isClean = $cage->clean();

        array_map(function (Animal $animal) use ($cage) {
            $cage->addAnimal($animal);
        }, $animals);

        return $isClean ? sprintf('Cage %d is clean!', $number) : sprintf('Cage %d is not clean!', $number);
    }

    public function cleanAllCages(): string
    {
        $cagesAreClean = '';

        for ($i = 0; $i < $this->cages->count(); $i++) {
            $cagesAreClean .= $this->cleanCage($i) . '<br>';
        }

        return $cagesAreClean;
    }

    private function initZoo(): void
    {
        $this->cages = $this->createCages();

        $this->fillAllCages();
    }

    private function createCages(): ArrayCollection
    {
        $cages = new ArrayCollection();

        $numberOfCages = (int) $this->zooConfig['cages'];

        for ($i = 0; $i < $numberOfCages; $i++) {
            $cages->add(new Cage());
        }

        return $cages;
    }

    private function fillAllCages(): void
    {
        $this->cages->first();

        foreach (self::ANIMAL_CLASSES as $configParam => $animalClass) {
            if (empty($this->zooConfig['animals'][$configParam])) {
                continue;
            }

            $numberOfAnimals = (int) $this->zooConfig['animals'][$configParam]['quantity'];
            $numberOfAnimalsInCage = (int) $this->zooConfig['animals'][$configParam]['quantity_in_cage'];

            $this->fillCagesWithOneTypeOfAnimals($animalClass, $numberOfAnimals, $numberOfAnimalsInCage);

            if ($numberOfAnimals % $numberOfAnimalsInCage != 0) {
                $this->cages->next();
            }
        }
    }

    private function fillCagesWithOneTypeOfAnimals(string $animalClass, int $numberOfAnimals, int $numberOfAnimalsInCage): void
    {
        for ($i = 0; $i < $numberOfAnimals; $i++) {
            $this->cages->current()->addAnimal(new $animalClass());

            if (($i + 1) % $numberOfAnimalsInCage === 0) {
                $this->cages->next();
            }
        }
    }
}
