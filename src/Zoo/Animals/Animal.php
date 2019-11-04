<?php

namespace App\Zoo\Animals;

abstract class Animal
{
    /**
     * @param string $food
     * @return string
     */
    public function eat(string $food)
    {
        return $this . ' eat ' . $food;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $type = explode('\\', static::class);

        return end($type);
    }
}