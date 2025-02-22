<?php

namespace App\Repository;

use App\Entity\Force;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Force>
 *
 * @method Force|null find($id, $lockMode = null, $lockVersion = null)
 * @method Force|null findOneBy(array $criteria, array $orderBy = null)
 * @method Force[]    findAll()
 * @method Force[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Force::class);
    }

//    /**
//     * @return Force[] Returns an array of Force objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Force
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
