<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $tag = new Tag();
        $tag->setName('Zoo');
        $tag->setSlug('zoo');

        $manager->persist($tag);

        $category = new Category();
        $category->setName('Zoo category');
        $category->setSlug('zoo-category');

        $manager->persist($category);

        $post = new Post();
        $post->setName('Zoo post');
        $post->setSlug('zoo-post');
        $post->setContent('zoo content');
        $post->setCategory($category);
        $post->addTag($tag);

        $manager->persist($post);

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->encoderFactory->getEncoder(User::class)->encodePassword('admin', null));

        $manager->persist($admin);

        $manager->flush();
    }
}
