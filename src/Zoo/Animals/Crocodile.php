<?php

namespace App\Zoo\Animals;

class Crocodile extends Animal
{
    /**
     * @return string
     */
    public function swim()
    {
        return $this . ' swim';
    }
}