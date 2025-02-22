<?php

namespace App\Repository;

use App\Entity\Tetst;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tetst>
 *
 * @method Tetst|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tetst|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tetst[]    findAll()
 * @method Tetst[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TetstRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tetst::class);
    }

//    /**
//     * @return Tetst[] Returns an array of Tetst objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tetst
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
