<?php

namespace App\Repository;

use App\Entity\Constrained;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Constrained|null find($id, $lockMode = null, $lockVersion = null)
 * @method Constrained|null findOneBy(array $criteria, array $orderBy = null)
 * @method Constrained[]    findAll()
 * @method Constrained[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstrainedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Constrained::class);
    }

    // /**
    //  * @return Constrained[] Returns an array of Constrained objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Constrained
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
