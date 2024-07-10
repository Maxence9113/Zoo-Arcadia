<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Meal>
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meal::class);
    }

    /**
     * Récupère les animaux en base de données
     * @return Meal[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('m')
            ->join('m.animal', 'a')
            ->join('m.employee', 'u')
            ->leftJoin('a.race', 'r')
            ->select('m', 'a', 'u', 'r')
            ->orderBy('m.date', 'ASC');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('u.username LIKE :q OR a.name LIKE :q OR m.date LIKE :q OR r.name LIKE :q OR r.habitat LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->employee)) {
            $query = $query
                ->andWhere('u.username IN (:employee)')
                ->setParameter('employee', $search->employee);
        }

        if (!empty($search->animal)) {
            $query = $query
                ->andWhere('a.name IN (:animal)')
                ->setParameter('animal', $search->animal);
        }

        if (!empty($search->race)) {
            $query = $query
                ->andWhere('a.race IN (:race)')
                ->setParameter('race', $search->race);
        }

        if (!empty($search->habitat)) {
            $query = $query
                ->andWhere('r.habitat IN (:habitat)')
                ->setParameter('habitat', $search->habitat);
        }



        return $query->getQuery()->getResult();
    }


    //    /**
    //     * @return Meal[] Returns an array of Meal objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Meal
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
