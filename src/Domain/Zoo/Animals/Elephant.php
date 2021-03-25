<?php

namespace App\Domain\Zoo\Animals;

class Elephant extends Animal
{
    public function waterYourselfTheTrunk(): string
    {
        return $this . ' water yourself the trunk';
    }
}
