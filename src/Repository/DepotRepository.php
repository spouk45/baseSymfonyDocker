<?php

namespace App\Repository;

use App\Entity\Depot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Depot>
 */
class DepotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Depot::class);
    }

    public function findDepotsByDateRange($epci, \DateTime $startDate, \DateTime $endDate)
    {
        $qb = $this->createQueryBuilder('d')
            ->andWhere('d.epci = :epci')
            ->andWhere('d.timestamp BETWEEN :startDate AND :endDate')
            ->setParameter('epci', $epci)
            ->setParameter('startDate', $startDate->getTimestamp())
            ->setParameter('endDate', $endDate->getTimestamp())
            ->orderBy('d.timestamp');

        return $qb->getQuery()->getResult();
    }
}
