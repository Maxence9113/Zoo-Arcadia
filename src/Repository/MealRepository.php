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
            ->select('m', 'a', 'u');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('r.name LIKE :q OR a.name LIKE :q')
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
