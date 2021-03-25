<?php

namespace App\Domain\Blog\Entity\Interfaces;

use Symfony\Component\String\Slugger\SluggerInterface;

interface SluggableInterface
{
    public function computeSlug(SluggerInterface $slugger): void;
}