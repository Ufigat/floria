<?php

namespace App\Repository;

use App\Entity\Hhhh;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hhhh>
 *
 * @method Hhhh|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hhhh|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hhhh[]    findAll()
 * @method Hhhh[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HhhhRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hhhh::class);
    }

//    /**
//     * @return Hhhh[] Returns an array of Hhhh objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Hhhh
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
