<?php declare(strict_types=1);

namespace App\Model\Service;

use App\Exception\DayNotFoundException;
use App\Exception\SubTaskAlreadyExistException;
use App\Exception\SubTaskNotFoundException;
use App\Exception\SubTaskTypeNotFoundException;
use App\Exception\TaskNotFoundException;
use App\Model\Dto\SubTask;
use App\Model\Entity\SubTask as SubTaskEntity;
use App\Model\Mapper\SubTaskMapper;
use App\Model\Repository\DayRepository;
use App\Model\Repository\SubTaskRepository;
use App\Model\Repository\SubTaskTypeRepository;
use App\Model\Repository\TaskRepository;
use App\Security\ApiSecurity;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Uid\Uuid;

/**
 * SubTaskService.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-04
 */
final class SubTaskService
{
    public function __construct(
        private ApiSecurity $security,
        private SubTaskRepository $subTaskRepository,
        private EntityManagerInterface $entityManager,
        private DayRepository $dayRepository,
        private TaskRepository $taskRepository,
        private SubTaskTypeRepository $subTaskTypeRepository,
    )
    {
    }

    /**
     * @throws DayNotFoundException
     * @throws TaskNotFoundException
     * @throws SubTaskTypeNotFoundException
     * @throws SubTaskAlreadyExistException
     */
    public function create(Uuid $dayUuid, Uuid $taskUuid, Uuid $subTaskTypeUuid, float $minutes): SubTask
    {
        $user = $this->security->getUser();

        // Fetch All entities becouse can be posted different owner. Also we need to validate each UUID.
        $day  = $this->dayRepository->fetchByUuid($user, $dayUuid);
        $task = $this->taskRepository->fetchByUuid($user, $taskUuid);
        $subTaskType = $this->subTaskTypeRepository->fetchByUuid($subTaskTypeUuid);

        try {
            $subtask = new SubTaskEntity()
                ->setDay($day)
                ->setTask($task)
                ->setSubTaskType($subTaskType)
                ->setMinutes($minutes)
                ->setUser($user);
            $this->entityManager->persist($subtask);

            $task->addSubTask($subtask);
            $this->entityManager->persist($task);

            $this->entityManager->flush();
        }
        catch (UniqueConstraintViolationException $e) {
            throw new SubTaskAlreadyExistException();
        }

        return SubTaskMapper::mapPostSubTask($subtask);
    }

    /**
     * @throws SubTaskNotFoundException
     */
    public function updateSubTaskMinutes(Uuid $uuid, float $minutes): SubTask
    {
        $user = $this->security->getUser();
        $subTask = $this->subTaskRepository->fetchByUuid($user, $uuid)
            ->addMinutes($minutes);

        $this->entityManager->persist($subTask);
        $this->entityManager->flush();

        return SubTaskMapper::mapPostSubTask($subTask);
    }
}
