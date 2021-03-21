<?php

namespace App\Zoo;

use App\Zoo\Animals\Animal;
use App\Zoo\Animals\Crocodile;
use App\Zoo\Animals\Elephant;
use App\Zoo\Animals\Lien;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Zoo
{
    /**
     * @var ArrayCollection
     */
    private $cages;

    /**
     * @var Container
     */
    private $container;

    private $params = [
        Lien::class => [
            'number' => 'zoo.liens.number',
            'number_in_cage' => 'zoo.liens.number_in_cage',
        ],
        Crocodile::class => [
            'number' => 'zoo.crocodiles.number',
            'number_in_cage' => 'zoo.crocodiles.number_in_cage',
        ],
        Elephant::class => [
            'number' => 'zoo.elephants.number',
            'number_in_cage' => 'zoo.elephants.number_in_cage',
        ],
    ];

    private $numberOfCagesParam = 'zoo.cages.number';

    public function __construct(Container $container)
    {
        $this->container = $container;

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

        $numberOfCages = (int) $this->container->getParameter($this->numberOfCagesParam);

        for ($i = 0; $i < $numberOfCages; $i++) {
            $cages->add(new Cage());
        }

        return $cages;
    }

    private function fillAllCages(): void
    {
        $this->cages->first();

        foreach ($this->params as $animalClass => $containerParams) {
            $numberOfAnimals = (int) $this->container->getParameter($containerParams['number']);
            $numberOfAnimalsInCage = (int) $this->container->getParameter($containerParams['number_in_cage']);

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
