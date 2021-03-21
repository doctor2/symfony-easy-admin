<?php

namespace App\Zoo;

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

        $this->fillWithAnimals();
    }

    public function getCages(): ArrayCollection
    {
        return $this->cages;
    }

    public function getCage(int $number): ?Cage
    {
        return $this->cages[$number] ?? null;
    }

    /**
     * @return mixed
     */
    public function cleanCage(int $number)
    {
        if (empty($this->cages[$number])) {
            throw new Exception('Wrong cage number!');
        }

        $animals = [];
        $b = 10;

        while ($animal = $this->cages[$number]->getLastAnimal()) {
            $this->cages[$number]->removeAnimal();

            $animals[] = $animal;

            if ($b-- < 0) {
                dd($animals);

                break;
            }
        }

        $result = $this->cages[$number]->clean();

        foreach ($animals as $animal) {
            $this->cages[$number]->addAnimal($animal);
        }

        return $result;
    }

    public function cleanAllCages(): string
    {
        $result = '';

        for ($i = 0; $i < count($this->cages); $i++) {
            $result .= "Cage $i is " . $this->cleanCage($i) . PHP_EOL;
        }

        return $result;
    }

    protected function fillWithAnimals(): void
    {
        $cages = new ArrayCollection();

        $numberOfCages = (int) $this->container->getParameter($this->numberOfCagesParam);
        for ($i = 0; $i < $numberOfCages; $i++) {
            $cages->add(new Cage());
        }

        $cagesCounter = 0;
        foreach ($this->params as $class => $param) {
            $numberOfAnimals = (int) $this->container->getParameter($param['number']);
            $numberOfAnimalsInCage = (int) $this->container->getParameter($param['number_in_cage']);

            for ($i = 0; $i < $numberOfAnimals; $i++) {
                $cages[$cagesCounter]->addAnimal(new $class());
                if (($i + 1) % $numberOfAnimalsInCage == 0) {
                    $cagesCounter++;
                }
            }

            if ($numberOfAnimals % $numberOfAnimalsInCage != 0) {
                $cagesCounter++;
            }
        }

        $this->cages = $cages;
    }
}
