<?php

namespace App\Repository;

use App\Entity\ExerciseState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExerciseState|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciseState|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciseState[]    findAll()
 * @method ExerciseState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciseStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciseState::class);
    }

    // /**
    //  * @return ExerciseState[] Returns an array of ExerciseState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExerciseState
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
