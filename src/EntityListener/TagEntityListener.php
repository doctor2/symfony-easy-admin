<?php

namespace App\EntityListener;

use App\Entity\Tag;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class TagEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Tag $tag, LifecycleEventArgs $event): void
    {
        $tag->computeSlug($this->slugger);
    }

    public function preUpdate(Tag $tag, LifecycleEventArgs $event): void
    {
        $tag->computeSlug($this->slugger);
    }
}
