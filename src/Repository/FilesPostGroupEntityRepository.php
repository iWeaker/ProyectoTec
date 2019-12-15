<?php

namespace App\Repository;

use App\Entity\FilesPostGroupEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FilesPostGroupEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilesPostGroupEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilesPostGroupEntity[]    findAll()
 * @method FilesPostGroupEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilesPostGroupEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilesPostGroupEntity::class);
    }

    // /**
    //  * @return FilesPostGroupEntity[] Returns an array of FilesPostGroupEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FilesPostGroupEntity
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
