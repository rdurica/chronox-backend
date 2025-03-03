<?php declare(strict_types=1);

namespace App\Model\Service;

use App\Exception\DayNotFoundException;
use App\Model\Dto\Task;
use App\Model\Entity\Task as TaskEntity;
use App\Model\Mapper\TaskMapper;
use App\Model\Repository\DayRepository;
use App\Security\ApiSecurity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

/**
 * TaskService.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-03
 */
final class TaskService
{
    public function __construct(
        private ApiSecurity $security,
        private DayRepository $dayRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    /**
     * @throws DayNotFoundException
     */
    public function create(string $title, Uuid $dayUuid): Task
    {
        $user = $this->security->getUser();
        $day = $this->dayRepository->fetchByUuid($user, $dayUuid);

        $task = new TaskEntity()
            ->setUser($user)
            ->setTitle($title)
            ->addDay($day);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return TaskMapper::mapCreateTask($task);
    }
}
