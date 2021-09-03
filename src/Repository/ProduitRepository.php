<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Entity\SousCategorie;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findByPage(SousCategorie $ssc, $page_number = 0, $number_products = 5)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sousCategorie = :ssc')
            ->setParameter('ssc', $ssc)
            //->orderBy('p.id', 'ASC')
            ->setFirstResult($page_number * $number_products)
            ->setMaxResults($number_products)
            ->getQuery()
            ->getResult();
    }

    public function countProduits(SousCategorie $ssc)
    {
        return count($this->createQueryBuilder('p')
            ->andWhere('p.sousCategorie = :ssc')
            ->setParameter('ssc', $ssc)
            //->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult());
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
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
