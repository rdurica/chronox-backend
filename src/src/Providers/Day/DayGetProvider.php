<?php declare(strict_types=1);

namespace App\Providers\Day;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Exception\DayNotFoundException;
use App\Model\Dto\Day;
use App\Model\Service\DayService;
use Symfony\Component\Uid\Uuid;

/**
 * Custom processor for managing the creation of {@see Day} entries.
 * This processor is used to handle the logic behind persisting a new `Day` entry,
 * ensuring that each entry is associated with the currently authenticated user.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-09
 * @implements ProviderInterface<Day>
 */
final class DayGetProvider implements ProviderInterface
{
    public function __construct(private DayService $dayService)
    {
    }

    /**
     * @param Operation                                                    $operation
     * @param array<string, Uuid>                                         $uriVariables
     * @param array<string, array{page: int|null, itemsPerPage: int|null}> $context
     *
     * @return Day
     * @throws DayNotFoundException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Day
    {
        return $this->dayService->getByUuid($uriVariables['uuid']);
    }
}
