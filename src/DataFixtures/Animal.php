<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Animal extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Creer entre 3 et 5 animaux par race
        $faker = \Faker\Factory::create('fr_FR');
        $races = $manager->getRepository(\App\Entity\Race::class)->findAll();

        foreach ($races as $race) {
            $nombreRace = rand(3, 8);

            for ($i = 0; $i < $nombreRace; $i++) {
                $animal = new \App\Entity\Animal();
                $animal->setName($faker->firstName);
                $animal->setRace($race);
                $manager->persist($animal);
            }
        }


        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            Race::class,
        ];
    }
}
