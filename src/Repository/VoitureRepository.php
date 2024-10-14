<?php

namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voiture>
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    /**
     * @return Voiture[] Returns an array of Voiture objects
     */
    public function findById($id): ?Voiture
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Voiture[] Returns an array of Voiture objects
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}