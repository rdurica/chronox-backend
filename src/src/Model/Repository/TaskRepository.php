<?php declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param int $dateId
     *
     * @return Task[]
     */
    public function findByDateId(int $dateId): array
    {
        /** @var Task[] $result */
        $result = $this->createQueryBuilder('t')
            ->leftJoin('t.days', 'd')
            ->where('d.id = :dateId')
            ->setParameter('dateId', $dateId)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
