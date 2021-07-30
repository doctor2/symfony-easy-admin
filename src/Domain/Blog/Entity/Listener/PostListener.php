<?php

namespace App\Domain\Blog\Entity\Listener;

use App\Domain\Blog\Entity\Post;
use DateTime;

class PostListener
{
    public function prePersist(Post $post): void
    {
        $datetime = new DateTime();

        $post->setCreatedAt($datetime);
        $post->setUpdatedAt($datetime);
    }

    public function preUpdate(Post $post): void
    {
        $post->setUpdatedAt(new DateTime());
    }
}
