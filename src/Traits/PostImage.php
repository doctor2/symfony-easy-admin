<?php


namespace App\Traits;


use App\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

trait PostImage
{
    /**
     * @var Post[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Post", cascade={"persist"})
     * @ORM\JoinTable(name="post_images",
     *      inverseJoinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")}
     * )
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * Get images
     *
     * @return Post[]|ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts[0] ?? null;
    }

    /**
     * @param Post $post
     * @return ArrayCollection
     */
    public function setPosts(Post $post)
    {
        $this->posts->clear();

        return $this->posts->add($post);
    }
}