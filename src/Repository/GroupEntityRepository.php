<?php

namespace App\Repository;

use App\Entity\GroupEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GroupEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupEntity[]    findAll()
 * @method GroupEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupEntity::class);
    }

    /**
    /  * @return GroupEntity[] Returns an array of GroupEntity objects
     */

    public function otherGroups($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.creator != :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?GroupEntity
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
