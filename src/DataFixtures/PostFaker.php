<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PostFaker extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        for ($i=0; $i < 50; $i++) { 
            $post = new Post();
            $post->setTitle($faker->words(4, true))
                 ->setContent($faker->realText(1800))
                 ->setState(mt_rand(0,1) === 0 ? Post::STATES[0] : Post::STATES[1]);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
