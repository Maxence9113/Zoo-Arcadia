<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Meal extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $animals = $manager->getRepository(\App\Entity\Animal::class)->findAll();

        foreach ($animals as $animal) {
            $nombreMeal = rand(3, 8);

            for ($i = 0; $i < $nombreMeal; $i++) {
                $meal = new \App\Entity\Meal();
                $meal->setQuantity($faker->numberBetween(10, 10000));
                $meal->setEmployee($this->getReference('employee' . rand(0, 19)));
                $meal->setAnimal($animal);
                $meal->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months')));
                $manager->persist($meal);
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
