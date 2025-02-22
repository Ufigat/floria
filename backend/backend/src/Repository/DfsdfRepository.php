<?php

namespace App\Repository;

use App\Entity\Dfsdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dfsdf>
 *
 * @method Dfsdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dfsdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dfsdf[]    findAll()
 * @method Dfsdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DfsdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dfsdf::class);
    }

//    /**
//     * @return Dfsdf[] Returns an array of Dfsdf objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Dfsdf
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
