<?php

namespace App\Repository;

use App\Entity\Librairy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Librairy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Librairy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Librairy[]    findAll()
 * @method Librairy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibrairyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Librairy::class);
    }

    // /**
    //  * @return Librairy[] Returns an array of Librairy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Librairy
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
