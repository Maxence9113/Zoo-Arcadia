<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Animal extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Creer 30 animaux
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {
            $animal = new \App\Entity\Animal();
            $animal->setName($faker->firstName);

            $animal->setRace($this->getReference('test' . rand(0, 29)));

            $manager->persist($animal);
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
