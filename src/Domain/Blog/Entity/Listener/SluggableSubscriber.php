<?php

namespace App\Domain\Blog\Entity\Listener;

use App\Domain\Blog\Entity\Interfaces\SluggableInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class SluggableSubscriber implements EventSubscriber
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->setSlug($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->setSlug($args);
    }

    private function setSlug(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof SluggableInterface) {
            return;
        }

        $entity->computeSlug($this->slugger);
    }
}
