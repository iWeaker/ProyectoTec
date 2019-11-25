<?php

namespace App\Repository;

use App\Entity\HeartEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method HeartEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method HeartEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method HeartEntity[]    findAll()
 * @method HeartEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeartEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HeartEntity::class);
    }

    // /**
    //  * @return HeartEntity[] Returns an array of HeartEntity objects
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
    public function findOneBySomeField($value): ?HeartEntity
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
