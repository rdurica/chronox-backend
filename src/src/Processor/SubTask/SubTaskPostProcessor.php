<?php declare(strict_types=1);

namespace App\Processor\SubTask;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Exception\DayNotFoundException;
use App\Exception\SubTaskTypeNotFoundException;
use App\Exception\TaskNotFoundException;
use App\Model\Dto\SubTask;
use App\Model\Dto\SubTaskPost;
use App\Model\Service\SubTaskService;

/**
 * @implements ProcessorInterface<SubTaskPost, SubTask>
 */
final class SubTaskPostProcessor implements ProcessorInterface
{
    public function __construct(private SubTaskService $subTaskService)
    {
    }

    /**
     * @param SubTaskPost          $data
     * @param Operation            $operation
     * @param array<string, mixed> $uriVariables
     * @param array<string, mixed> $context
     *
     * @return SubTask
     * @throws DayNotFoundException
     * @throws SubTaskTypeNotFoundException
     * @throws TaskNotFoundException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): SubTask
    {
        return $this->subTaskService->create($data->dayUuid, $data->taskUuid, $data->subTaskTypeUuid, $data->minutes);
    }
}
