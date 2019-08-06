<?php

namespace App\Repository;

use App\Entity\LeitorAutor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LeitorAutor|null find($id, $lockMode = null, $lockVersion = null)
 * @method LeitorAutor|null findOneBy(array $criteria, array $orderBy = null)
 * @method LeitorAutor[]    findAll()
 * @method LeitorAutor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeitorAutorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LeitorAutor::class);
    }

    // /**
    //  * @return LeitorAutor[] Returns an array of LeitorAutor objects
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
    public function findOneBySomeField($value): ?LeitorAutor
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
