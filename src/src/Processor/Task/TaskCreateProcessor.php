<?php declare(strict_types=1);

namespace App\Processor\Task;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Exception\DayNotFoundException;
use App\Model\Dto\Task;
use App\Model\Service\TaskService;

/**
 * @implements ProcessorInterface<Task, Task>
 */
final class TaskCreateProcessor implements ProcessorInterface
{
    public function __construct(private TaskService $taskService)
    {
    }

    /**
     * @param Task                 $data
     * @param Operation            $operation
     * @param array<string, mixed> $uriVariables
     * @param array<string, mixed> $context
     *
     * @return Task
     * @throws DayNotFoundException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Task
    {
        return $this->taskService->create($data->title, $data->dayUuid);
    }
}
