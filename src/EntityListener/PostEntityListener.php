<?php

namespace App\EntityListener;

use App\Entity\Post;
use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PostEntityListener
{
    public function prePersist(Post $post, LifecycleEventArgs $event): void
    {
        $datetime = new DateTime();

        $post->setCreatedAt($datetime);
        $post->setUpdatedAt($datetime);
    }

    public function preUpdate(Post $post, LifecycleEventArgs $event): void
    {
        $post->setUpdatedAt(new DateTime());
    }
}
