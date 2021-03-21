<?php

namespace App\Zoo\Animals;

class Lien extends Animal
{
    public function growl(): string
    {
        return $this . ' growl';
    }
}