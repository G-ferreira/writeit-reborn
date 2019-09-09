<?php

namespace App\Repository;

use App\Entity\Historico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Historico|null find($id, $lockMode = null, $lockVersion = null)
 * @method Historico|null findOneBy(array $criteria, array $orderBy = null)
 * @method Historico[]    findAll()
 * @method Historico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoricoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Historico::class);
    }

    // /**
    //  * @return Historico[] Returns an array of Historico objects
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
    public function findOneBySomeField($value): ?Historico
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
