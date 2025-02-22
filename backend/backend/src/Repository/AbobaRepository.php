<?php

namespace App\Repository;

use App\Entity\Aboba;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Aboba>
 *
 * @method Aboba|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aboba|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aboba[]    findAll()
 * @method Aboba[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbobaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aboba::class);
    }

//    /**
//     * @return Aboba[] Returns an array of Aboba objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Aboba
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
