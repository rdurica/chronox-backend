<?php declare(strict_types=1);

namespace App\Model\Repository;

use App\Exception\TaskNotFoundException;
use App\Model\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

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
     * @throws TaskNotFoundException
     */
    public function fetchByUuid(UserInterface $user, Uuid $uuid): Task
    {
        /** @var ?Task $result */
        $result = $this->createQueryBuilder('t')
            ->andWhere('t.uuid = :uuid')
            ->andWhere('t.user = :user')
            ->setParameter('uuid', $uuid->toBinary())
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();

        if ($result === null) {
            throw new TaskNotFoundException();
        }

        return $result;
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
