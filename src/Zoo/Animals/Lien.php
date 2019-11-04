<?php

namespace App\Zoo\Animals;

class Lien extends Animal
{
    /**
     * @return string
     */
    public function growl()
    {
        return $this . ' growl';
    }
}