<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setFirstname($faker->firstname);
        $admin->setLastname($faker->lastname);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        for ($i = 1; $i <= 50; $i++) {
            $user = new User();
            $user->setEmail("user$i@gmail.com");
            $user->setFirstname($faker->firstname);
            $user->setLastname($faker->lastname);
            $user->setPassword($this->hasher->hashPassword($user, 'user'));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }


            $manager->flush();
        }
    }

