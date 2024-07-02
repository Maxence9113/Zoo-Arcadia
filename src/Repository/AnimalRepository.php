<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    /**
     * Récupère les animaux en base de données
     * @return Animal[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('a')
            ->join('a.race', 'r')
            ->select('r', 'a');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('r.name LIKE :q OR a.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->race)) {
            $query = $query
                ->andWhere('r.id IN (:race)')
                ->setParameter('race', $search->race);
        }

        if (!empty($search->habitat)) {
            $query = $query
                ->andWhere('r.habitat IN (:habitat)')
                ->setParameter('habitat', $search->habitat);
        }


        return $query->getQuery()->getResult();
    }
}
