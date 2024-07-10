<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Race extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // creation de 30 Races

        $faker = \Faker\Factory::create('fr_FR');
        $habitats = ['HABITAT_SAVANE', 'HABITAT_JUNGLE', 'HABITAT_MARAIS'];
        $animals = ["Lion", "Tigre", "Éléphant", "Girafe", "Zèbre", "Panda géant", "Gorille", "Hippopotame", "Rhinocéros", "Kangourou", "Ours polaire", "Loup", "Lémurien", "Autruche", "Flamant rose", "Pingouin", "Jaguar", "Panthère des neiges", "Orang-outan", "Chameau"];



        for ($i = 0; $i < 30; $i++) {
            $race = new \App\Entity\Race();
            $ramdomHabitat = $habitats[array_rand($habitats)];
            $race->setHabitat($ramdomHabitat);
            $ramdomAnimal = $animals[array_rand($animals)];
            $race->setName($ramdomAnimal);
            $race->setDescription($faker->text);

            $race->setIllustration($faker->imageUrl());
            $race->setIllustrationAlt($faker->word);
            $manager->persist($race);
        }

        $manager->flush();
    }
}
