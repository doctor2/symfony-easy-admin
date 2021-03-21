<?php

namespace App\Zoo\Animals;

abstract class Animal
{
    public function eat(string $food): string
    {
        return $this . ' eat ' . $food;
    }

    public function __toString(): string
    {
        $type = explode('\\', static::class);

        return end($type);
    }
}
