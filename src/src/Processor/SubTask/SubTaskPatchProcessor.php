<?php declare(strict_types=1);

namespace App\Processor\SubTask;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Exception\SubTaskNotFoundException;
use App\Model\Dto\SubTask;
use App\Model\Dto\SubTaskPatch;
use App\Model\Service\SubTaskService;

/**
 * @implements ProcessorInterface<SubTaskPatch, SubTask>
 */
final class SubTaskPatchProcessor implements ProcessorInterface
{
    public function __construct(private SubTaskService $subTaskService)
    {
    }

    /**
     * @param SubTaskPatch         $data
     * @param Operation            $operation
     * @param array<string, mixed> $uriVariables
     * @param array<string, mixed> $context
     *
     * @return SubTask
     * @throws SubTaskNotFoundException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): SubTask
    {
        return $this->subTaskService->updateSubTaskMinutes($data->uuid, $data->minutes);
    }
}
