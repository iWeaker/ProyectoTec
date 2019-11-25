<?php

namespace App\Repository;

use App\Entity\PostEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PostEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostEntity[]    findAll()
 * @method PostEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostEntity::class);
    }

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.userPost = :val')
            ->setParameter('val', $value)
            ->orderBy('p.datePost', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            
            ->getResult()
            ;
    }

    // /**
    //  * @return PostEntity[] Returns an array of PostEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostEntity
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
