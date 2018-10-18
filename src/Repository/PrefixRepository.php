<?php

namespace App\Repository;

use App\Entity\Prefix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Prefix|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prefix|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prefix[]    findAll()
 * @method Prefix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrefixRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Prefix::class);
    }

//    /**
//     * @return Prefix[] Returns an array of Prefix objects
//     */
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
    public function findOneBySomeField($value): ?Prefix
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
