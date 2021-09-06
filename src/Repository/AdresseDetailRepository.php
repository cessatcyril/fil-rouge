<?php

namespace App\Repository;

use App\Entity\AdresseDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdresseDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdresseDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdresseDetail[]    findAll()
 * @method AdresseDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdresseDetail::class);
    }

    // /**
    //  * @return AdresseDetail[] Returns an array of AdresseDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdresseDetail
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
