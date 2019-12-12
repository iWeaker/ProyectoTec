<?php

namespace App\Repository;

use App\Entity\ImgEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ImgEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImgEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImgEntity[]    findAll()
 * @method ImgEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImgEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImgEntity::class);
    }

    /**
     * /* @return ImgEntity[] Returns an array of ImgEntity objects
     * /*
     * @param $value
     * @return mixed
     */
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.user = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?ImgEntity
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
