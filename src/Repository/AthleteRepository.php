<?php

namespace App\Repository;

use App\Entity\Athlete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Athlete>
 */
class AthleteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Athlete::class);
    }

    public function findByCategory(string $category): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.category = :category')
            ->setParameter('category', $category)
            ->orderBy('a.lastName', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
