<?php

namespace App\Repository;

use App\Entity\LivraisonDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivraisonDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivraisonDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivraisonDetail[]    findAll()
 * @method LivraisonDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivraisonDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivraisonDetail::class);
    }

    // /**
    //  * @return LivraisonDetail[] Returns an array of LivraisonDetail objects
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
    public function findOneBySomeField($value): ?LivraisonDetail
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
