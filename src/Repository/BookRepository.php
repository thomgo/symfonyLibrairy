<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findBooksAndCategory($min, $max, User $user = null, Category $category = null)
    {
      $request = $this->createQueryBuilder('b')
        ->addSelect('c')
        ->leftJoin('b.category', 'c');
      if($user) {
        $request = $request->where('b.librairy = :librairy')->setParameter('librairy', $user->getLibrairy());
      }
      if($category) {
        $request = $request->andWhere('b.category = :category')->setParameter('category', $category);
      }
        return $request->orderBy('b.id', 'ASC')
        ->setFirstResult($min)
        ->setMaxResults($max)
        ->getQuery()
        ->getResult();
    }

    public function findBookAndUser(int $id): ?Book
    {
      return $this->createQueryBuilder('b')
        ->addSelect('u')
        ->leftJoin('b.borrower', 'u')
        ->addSelect('c')
        ->leftJoin('b.category', 'c')
        ->andWhere('b.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getOneOrNullResult();
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
