<?php

namespace App\Repository;

use App\Entity\Competition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Competition>
 */
class CompetitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competition::class);
    }

    public function findLive(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.status = :status')
            ->setParameter('status', 'live')
            ->orderBy('c.startAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findUpcoming(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.status = :status')
            ->setParameter('status', 'scheduled')
            ->andWhere('c.startAt > :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('c.startAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
