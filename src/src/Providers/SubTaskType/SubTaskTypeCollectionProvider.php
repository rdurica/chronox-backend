<?php declare(strict_types=1);

namespace App\Providers\SubTaskType;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Model\Dto\SubTaskType;
use App\Model\Service\SubTaskTypeService;

/**
 * @implements ProviderInterface<SubTaskType>
 */
class SubTaskTypeCollectionProvider implements ProviderInterface
{
    public function __construct(private SubTaskTypeService $subTaskTypeService)
    {
    }

    /**
     * @param Operation                                                    $operation
     * @param array<string, mixed>                                         $uriVariables
     * @param array<string, array{page: int|null, itemsPerPage: int|null}> $context
     *
     * @return SubTaskType[]
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->subTaskTypeService->getSubTaskTypes();
    }
}
