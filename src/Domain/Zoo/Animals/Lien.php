<?php

namespace App\Domain\Zoo\Animals;

class Lien extends Animal
{
    public function growl(): string
    {
        return $this . ' growl';
    }
}