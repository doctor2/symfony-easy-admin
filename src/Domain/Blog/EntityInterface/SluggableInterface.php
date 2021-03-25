<?php

namespace App\Domain\Blog\EntityInterface;

use Symfony\Component\String\Slugger\SluggerInterface;

interface SluggableInterface
{
    public function computeSlug(SluggerInterface $slugger): void;
}