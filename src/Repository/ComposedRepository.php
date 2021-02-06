<?php

namespace App\Repository;

use App\Entity\Composed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Composed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Composed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Composed[]    findAll()
 * @method Composed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComposedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Composed::class);
    }

    // /**
    //  * @return Composed[] Returns an array of Composed objects
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
    public function findOneBySomeField($value): ?Composed
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
