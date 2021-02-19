<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
    /**
     * @return User[] Returns an array of User objects
     */
    public function findByRoles($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE \'%' . $value  . '%\'')
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * A method to return a certain amount of users given a page number.
     *
     * @param integer $pageNumber The number of the page
     * @param integer $numberOfItemsOnPage The number of items on each page
     * @return Array An array containing the result of the search with the key 'results' and the number of pages with the key 'numberOfPages'
     */
    public function findUsersByPageWithSearchCriteria(int $pageNumber, int $numberOfItemsOnPage) : Array
    { 

        // build the query for the doctrine paginator
        $query = $this->createQueryBuilder('u')
        ->orderBy('u.id', 'DESC')
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
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
