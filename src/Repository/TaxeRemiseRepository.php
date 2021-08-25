<?php

namespace App\Repository;

use App\Entity\TaxeRemise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaxeRemise|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxeRemise|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxeRemise[]    findAll()
 * @method TaxeRemise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxeRemiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxeRemise::class);
    }

    // /**
    //  * @return TaxeRemise[] Returns an array of TaxeRemise objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaxeRemise
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
