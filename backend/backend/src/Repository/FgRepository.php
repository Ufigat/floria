<?php

namespace App\Repository;

use App\Entity\Fg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fg>
 *
 * @method Fg|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fg|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fg[]    findAll()
 * @method Fg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fg::class);
    }

//    /**
//     * @return Fg[] Returns an array of Fg objects
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

//    public function findOneBySomeField($value): ?Fg
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
