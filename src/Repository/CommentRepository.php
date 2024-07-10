<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findSearch(SearchData $search, array $orderBy = ['createdAt' => 'DESC']): array
    {
        $query = $this
            ->createQueryBuilder('c')
            ->select('c');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('c.username LIKE :q OR c.createdAt LIKE :q OR c.comment LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->isApprouved)) {
            $query = $query
                ->andWhere('c.isApprouved IN (:isApprouved)')
                ->setParameter('isApprouved', $search->isApprouved);
        }

        if (!empty($search->note)) {
            $query = $query
                ->andWhere('c.note IN (:note)')
                ->setParameter('note', $search->note);
        }

        foreach ($orderBy as $field => $direction) {
            $query->addOrderBy('c.' . $field, $direction);
        }

        return $query->getQuery()->getResult();
    }
}
