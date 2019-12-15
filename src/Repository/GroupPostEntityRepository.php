<?php

namespace App\Repository;

use App\Entity\GroupPostEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GroupPostEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupPostEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupPostEntity[]    findAll()
 * @method GroupPostEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupPostEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupPostEntity::class);
    }

    // /**
    //  * @return GroupPostEntity[] Returns an array of GroupPostEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupPostEntity
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
