<?php

namespace App\Repository;

use App\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 *
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function findWithPagination(int $page, int $limit): Paginator
    {
        $qb = $this->createQueryBuilder('notification')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($qb, true);
    }

    public function save(Notification $notification): Notification
    {
        $this->getEntityManager()->persist($notification);
        $this->getEntityManager()->flush();

        return $notification;
    }
}
