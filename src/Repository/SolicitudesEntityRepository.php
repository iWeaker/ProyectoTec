<?php

namespace App\Repository;

use App\Entity\SolicitudesEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SolicitudesEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolicitudesEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolicitudesEntity[]    findAll()
 * @method SolicitudesEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolicitudesEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolicitudesEntity::class);
    }

    // /**
    //  * @return SolicitudesEntity[] Returns an array of SolicitudesEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SolicitudesEntity
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
