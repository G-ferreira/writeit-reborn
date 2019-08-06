<?php

namespace App\Repository;

use App\Entity\AutorLeitor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AutorLeitor|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutorLeitor|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutorLeitor[]    findAll()
 * @method AutorLeitor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutorLeitorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AutorLeitor::class);
    }

    // /**
    //  * @return AutorLeitor[] Returns an array of AutorLeitor objects
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
    public function findOneBySomeField($value): ?AutorLeitor
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
