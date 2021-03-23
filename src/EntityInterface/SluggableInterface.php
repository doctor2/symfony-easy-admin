<?php

namespace App\EntityInterface;

use Symfony\Component\String\Slugger\SluggerInterface;

interface SluggableInterface
{
    public function computeSlug(SluggerInterface $slugger): void;
}
