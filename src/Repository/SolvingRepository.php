<?php

namespace App\Repository;

use App\Entity\Solving;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Solving|null find($id, $lockMode = null, $lockVersion = null)
 * @method Solving|null findOneBy(array $criteria, array $orderBy = null)
 * @method Solving[]    findAll()
 * @method Solving[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolvingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Solving::class);
    }

    // /**
    //  * @return Solving[] Returns an array of Solving objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Solving
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
