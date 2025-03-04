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
            ->leftJoin('t.subTasks', 'st')
            ->where('d.id = :dateId')
            ->andWhere('st.day = :dateId')
            ->setParameter('dateId', $dateId)
            ->addSelect('st')
            ->getQuery()
            ->getResult();

        return $result;
    }
}
