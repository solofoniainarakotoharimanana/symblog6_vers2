<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {

    }
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');
        $user = new User;

        $user->setEmail($faker->email())
            ->setFirstname($faker->firstName())
            ->setAvatar($faker->imageUrl())
            ->setPlainPassword('password')
        ->setLastname($faker->lastName())
        ->setPassword(
            $this->hasher->hashPassword($user, 'password')
        );
         
        $manager->persist($user);
        
        for ($i=0; $i < 10; $i++) {
            $user = new User;
            $user->setEmail($faker->email())
            ->setFirstname($faker->firstName())
            ->setPlainPassword('password')
            ->setAvatar($faker->imageUrl())
            ->setLastname($faker->lastName())
            ->setPassword(
                $this->hasher->hashPassword($user, 'password')
            );

            
            $manager->persist($user);
        }

        $manager->flush();
    }
}
