<?php

namespace App\DataFixtures;

use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Race extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // creation des Races

        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));
        $habitats = ['HABITAT_SAVANNAH', 'HABITAT_JUNGLE', 'HABITAT_SWAMP'];
        $races = ["Lion", "Tigre", "Éléphant", "Girafe", "Zèbre", "Panda géant", "Gorille", "Hippopotame", "Rhinocéros", "Kangourou", "Ours polaire", "Loup", "Lémurien", "Autruche", "Flamant rose", "Pingouin", "Jaguar", "Panthère des neiges", "Orang-outan", "Chameau"];


        foreach ($races as $raceName) {
            $race = new \App\Entity\Race();
            $ramdomHabitat = $habitats[array_rand($habitats)];
            $race->setHabitat($ramdomHabitat);
            $race->setName($raceName);
            $race->setDescription($faker->text);

            $url = $faker->imageUrl(500, 500, true);
            $race->setIllustration($url);
            $race->setIllustrationAlt($faker->word);
            $manager->persist($race);
            // $this->addReference($raceName, $race);
        }

        $manager->flush();
    }
}
