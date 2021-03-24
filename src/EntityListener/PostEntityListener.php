<?php

namespace App\EntityListener;

use App\Entity\Post;
use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Post $post, LifecycleEventArgs $event): void
    {
        $datetime = new DateTime();

        $post->setCreatedAt($datetime);
        $post->setUpdatedAt($datetime);

        $post->computeSlug($this->slugger);
    }

    public function preUpdate(Post $post, LifecycleEventArgs $event): void
    {
        $post->setUpdatedAt(new DateTime());

        $post->computeSlug($this->slugger);
    }
}
