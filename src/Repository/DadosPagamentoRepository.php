<?php

namespace App\Repository;

use App\Entity\DadosPagamento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DadosPagamento|null find($id, $lockMode = null, $lockVersion = null)
 * @method DadosPagamento|null findOneBy(array $criteria, array $orderBy = null)
 * @method DadosPagamento[]    findAll()
 * @method DadosPagamento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DadosPagamentoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DadosPagamento::class);
    }

    // /**
    //  * @return DadosPagamento[] Returns an array of DadosPagamento objects
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
    public function findOneBySomeField($value): ?DadosPagamento
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
