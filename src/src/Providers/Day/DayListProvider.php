<?php declare(strict_types=1);

namespace App\Providers\Day;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Model\Dto\Day;
use App\Model\Service\DayService;

/**
 * Provides a custom data provider for the {@see Day} entity.
 * This state provider is used in API Platform to retrieve paginated and
 * user-specific `Day` entries. It ensures that users can only fetch their
 * own records while preserving pagination and sorting.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-10
 * @implements ProviderInterface<Day>
 */
class DayListProvider implements ProviderInterface
{
    public function __construct(private DayService $dayService)
    {
    }

    /**
     * @param Operation                                                    $operation
     * @param array<string, mixed>                                         $uriVariables
     * @param array<string, array{page: int|null, itemsPerPage: int|null}> $context
     *
     * @return Day[]
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $page = $context['filters']['page'] ?? 1;
        $itemsPerPage = $context['filters']['itemsPerPage'] ?? 20;

        return $this->dayService->getPaginatedData((int)$page, (int)$itemsPerPage);
    }
}
