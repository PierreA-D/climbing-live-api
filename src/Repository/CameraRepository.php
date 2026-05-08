<?php

namespace App\Repository;

use App\Entity\Camera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Camera>
 */
class CameraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Camera::class);
    }

    public function findAuthorized(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.authorized = :authorized')
            ->setParameter('authorized', true)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOnline(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.status = :status')
            ->setParameter('status', 'online')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
