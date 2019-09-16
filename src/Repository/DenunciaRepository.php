<?php

namespace App\Repository;

use App\Entity\Denuncia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Denuncia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Denuncia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Denuncia[]    findAll()
 * @method Denuncia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DenunciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Denuncia::class);
    }

    // /**
    //  * @return Denuncia[] Returns an array of Denuncia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Denuncia
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
