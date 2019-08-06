<?php

namespace App\Repository;

use App\Entity\Historia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Historia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Historia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Historia[]    findAll()
 * @method Historia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Historia::class);
    }

    // /**
    //  * @return Historia[] Returns an array of Historia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Historia
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
