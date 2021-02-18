<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Exercise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exercise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exercise[]    findAll()
 * @method Exercise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciseRepository extends ServiceEntityRepository
{
    public static $PATH_TO_EXERCISES_FOLDER = "../exercises";
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }
    /**
     * A method to return a certain amount of exercises given a page number.
     *
     * @param integer $pageNumber The number of the page
     * @param integer $numberOfItemsOnPage The number of items on each page
     * @return Array An array containing the result of the search with the key 'results' and the number of pages with the key 'numberOfPages'
     */
    public function findExercisesByPageWithSearchCriteria(int $pageNumber, int $numberOfItemsOnPage) : Array
    { 

        // build the query for the doctrine paginator
        $query = $this->createQueryBuilder('e')
        ->orderBy('e.state', 'ASC')
        ->getQuery();

        // load doctrine Paginator
        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);

        // you can get total items
        $totalItems = count($paginator);

        // get total pages
        $pagesCount = ceil($totalItems / $numberOfItemsOnPage);

        // now get one page's items:
        $results = $paginator
            ->getQuery()
            ->setFirstResult($numberOfItemsOnPage * ($pageNumber - 1)) // set the offset
            ->setMaxResults($numberOfItemsOnPage)
            ->execute(); // set the limit

        // return stuff..
        return ['results' => $results, 'numberOfPages' => $pagesCount];
    }


    // /**
    //  * @return Exercise[] Returns an array of Exercise objects
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
    public function findOneBySomeField($value): ?Exercise
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
