<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Bluemmb\Faker\PicsumPhotosProvider;

class AnimalPicture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Creer entre 3 et 8 images par Animal
        $faker = \Faker\Factory::create();
        $faker->addProvider(new PicsumPhotosProvider($faker));
        $animals = $manager->getRepository(\App\Entity\Animal::class)->findAll();

        foreach ($animals as $animal) {
            $nombreImages = rand(3, 8);

            for ($i = 0; $i < $nombreImages; $i++) {
                $url = $faker->imageUrl(500, 500, true);
                $animalPicture = new \App\Entity\AnimalPicture();
                $animalPicture->setName($url);
                $animalPicture->setDescriptionAlt($faker->sentence);
                $animalPicture->setAnimal($animal);
                $manager->persist($animalPicture);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            Animal::class,
        ];
    }
}
