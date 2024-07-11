<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VeterinaryReport extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Création de 2 Rapport Véterinaire par animal
        $faker = \Faker\Factory::create();
        $animals = $manager->getRepository(\App\Entity\Animal::class)->findAll();

        foreach ($animals as $animal) {
            $nombreReport = 5;

            for ($i = 0; $i < $nombreReport; $i++) {
                $veterinaryReport = new \App\Entity\VeterinaryReport();
                $veterinaryReport->setComment($faker->text(200));
                $veterinaryReport->setEmployee($this->getReference('employee' . rand(0, 19)));
                $veterinaryReport->setAnimal($animal);
                $veterinaryReport->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 days')));
                $veterinaryReport->setMeal($this->getReference($animal->getId() . 'meal' . $i));
                $manager->persist($veterinaryReport);
            }
        }


        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            Meal::class,
            User::class,
            Animal::class,
        ];
    }
}
