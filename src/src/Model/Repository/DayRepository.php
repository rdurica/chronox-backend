<?php declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Day;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Day>
 */
class DayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Day::class);
    }

    /**
     * @return array{date: DateTime, uuid: Uuid, taskCount: int, totalMinutes: int}|null
     */
    public function findByUuid(UserInterface $user, Uuid $uuid): ?array
    {
        /** @var array{date: DateTime, uuid: Uuid, taskCount: int, totalMinutes: int}|null $result */
        $result = $this->createQueryBuilder('d')
            ->select('d.entryDate as date, d.uuid, count(t.id) as taskCount, sum(st.minutes) as totalMinutes')
            ->leftJoin('d.tasks', 't')
            ->leftJoin('t.subTasks', 'st')
            ->andWhere('d.user = :user')
            ->andWhere('d.uuid = :uuid')
            ->setParameter('user', $user)
            ->setParameter('uuid', $uuid->toBinary())
            ->groupBy('d.id')
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }

    /**
     * @return array<array{date: DateTime, uuid: Uuid, taskCount: int, totalMinutes: int}>
     */
    public function getPaginatedData(UserInterface $user, int $page = 1, int $itemsPerPage = 20): array
    {
        /** @var array<array{date: DateTime, uuid: Uuid, taskCount: int, totalMinutes: int}> $result */
        $result = $this->createQueryBuilder('d')
            ->select('d.entryDate as date, d.uuid, count(t.id) as taskCount, sum(st.minutes) as totalMinutes')
            ->leftJoin('d.tasks', 't')
            ->leftJoin('t.subTasks', 'st')
            ->where('d.user = :user')
            ->setParameter('user', $user)
            ->orderBy('d.entryDate', 'DESC')
            ->setFirstResult(($page - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage)
            ->groupBy('d.id')
            ->getQuery()
            ->getArrayResult();

        return $result;
    }
}
