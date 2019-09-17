<?php

namespace App\Repository;

use App\Entity\Contribuicao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contribuicao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contribuicao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contribuicao[]    findAll()
 * @method Contribuicao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContribuicaoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contribuicao::class);
    }

    // /**
    //  * @return Contribuicao[] Returns an array of Contribuicao objects
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
    public function findOneBySomeField($value): ?Contribuicao
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
