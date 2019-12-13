<?php

namespace App\Repository;

use App\Entity\AceptedEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AceptedEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AceptedEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AceptedEntity[]    findAll()
 * @method AceptedEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AceptedEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AceptedEntity::class);
    }

    // /**
    //  * @return AceptedEntity[] Returns an array of AceptedEntity objects
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
    public function findOneBySomeField($value): ?AceptedEntity
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
