<?php

namespace App\Repository;

use App\Entity\PageContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageContact[]    findAll()
 * @method PageContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageContact::class);
    }

    // /**
    //  * @return PageContact[] Returns an array of PageContact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageContact
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
