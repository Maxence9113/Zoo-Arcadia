<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class User extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // Creer 20 employés
        $faker = \Faker\Factory::create('fr_FR');
        $profils = ['ROLE_ADMIN', 'ROLE_EMPLOYEE', 'ROLE_VETERINARY'];

        for ($i = 0; $i < 20; $i++) {
            $user = new \App\Entity\User();
            $user->setFirstname($faker->lastName);
            $user->setLastname($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $ramdomProfil = $profils[array_rand($profils)];
            $user->setProfil($ramdomProfil);
            $user->setUsername($faker->userName);
            $manager->persist($user);
            $this->addReference('employee' . $i, $user);
        }

        $manager->flush();
    }
}
