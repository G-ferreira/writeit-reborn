<?php

namespace App\Repository;

use App\Entity\Capitulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Capitulo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Capitulo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Capitulo[]    findAll()
 * @method Capitulo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapituloRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Capitulo::class);
    }

    // /**
    //  * @return Capitulo[] Returns an array of Capitulo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Capitulo
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
