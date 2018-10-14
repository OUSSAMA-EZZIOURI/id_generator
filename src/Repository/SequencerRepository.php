<?php

namespace App\Repository;

use App\Entity\Sequencer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Sequencer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sequencer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sequencer[]    findAll()
 * @method Sequencer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SequencerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Sequencer::class);
    }

//    /**
//     * @return Sequencer[] Returns an array of Sequencer objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sequencer
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
