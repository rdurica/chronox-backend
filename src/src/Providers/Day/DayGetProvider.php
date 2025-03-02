<?php declare(strict_types=1);

namespace App\Providers\Day;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Exception\DayNotFoundException;
use App\Model\Dto\Day;
use App\Model\Service\DayService;

/**
 * Custom processor for managing the creation of {@see Day} entries.
 *
 * This processor is used to handle the logic behind persisting a new `Day` entry,
 * ensuring that each entry is associated with the currently authenticated user.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-09
 */
final class DayGetProvider implements ProviderInterface
{
    public function __construct(private DayService $dayService)
    {
    }

    /**
     * @throws DayNotFoundException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->dayService->getByUuid($uriVariables['uuid']);
    }
}
