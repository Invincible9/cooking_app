<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserCourseView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCourseView>
 */
class UserCourseViewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCourseView::class);
    }

    public function findLatestView(User $user): ?UserCourseView
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.user = :user')
            ->setParameter('user', $user)
            ->orderBy('v.viewedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countViewsInLast24h(User $user): int
    {
        $since = new \DateTimeImmutable('-24 hours');

        return $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->andWhere('v.user = :user')
            ->andWhere('v.viewedAt >= :since')
            ->setParameter('user', $user)
            ->setParameter('since', $since)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countTotalViews(User $user): int
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->andWhere('v.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
