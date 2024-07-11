<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Comment extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $nombreComment = 30;
        // Création de 30 commentaires
        for ($i = 0; $i < $nombreComment; $i++) {
            $comment = new \App\Entity\Comment();
            $comment->setComment($faker->text(200));
            $comment->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months')));
            $comment->setUsername($faker->userName);
            $comment->setNote($faker->numberBetween(1, 5));
            $comment->setIsApprouved($faker->boolean());
            $manager->persist($comment);
        }

        $manager->flush();
    }
}
