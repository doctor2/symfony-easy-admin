<?php

namespace App\Domain\Zoo\Animals;

class Crocodile extends Animal
{
    public function swim(): string
    {
        return $this . ' swim';
    }
}
