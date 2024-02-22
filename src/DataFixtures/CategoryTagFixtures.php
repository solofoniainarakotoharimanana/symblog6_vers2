<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\Category;
use App\Entity\Tag;
use App\Repository\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryTagFixtures extends Fixture implements DependentFixtureInterface
{


    public function __construct(private PostRepository $postRepository)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $categories = [];
       
        $posts = $this->postRepository->findAll();

        //Categories
        for ($i=1; $i <= 10 ; $i++) {
            $category = new Category();

            $category->setName($faker->words(1, true).' '.$i)
                ->setDescription(mt_rand(0, 1) === 1 ? $faker->realText(254) : null);
            
            $manager->persist($category);
            $categories[] = $category;  
        }

        foreach ($posts as $post) {
            for ($i=1; $i < mt_rand(1, 5); $i++) { 
                    $post->addCategory(
                    $categories[mt_rand(0, count($categories) - 1)]
                );
            }
            
        }

        //Tags
         $tags = [];
        for ($i=1; $i <= 10 ; $i++) {
            $tag = new Tag();

            $tag->setName($faker->words(1, true).' '.$i)
                ->setDescription(mt_rand(0, 1) === 1 ? $faker->realText(254) : null);
            
            $manager->persist($tag);
            $tags[] = $tag;  
        }


        
        foreach ($posts as $post) {
            for ($i=1; $i < mt_rand(1, 5); $i++) { 
                    $post->addTag(
                    $tags[mt_rand(0, count($tags) - 1)]
                );
            }
            
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [PostFaker::class];
    }
}