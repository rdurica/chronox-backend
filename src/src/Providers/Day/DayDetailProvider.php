<?php declare(strict_types=1);

namespace App\Providers\Day;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Exception\DayNotFoundException;
use App\Model\Dto\Day;
use App\Model\Service\DayService;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProviderInterface<Day>
 */
final class DayDetailProvider implements ProviderInterface
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
        return $this->dayService->getDetail($uriVariables['uuid']);
    }
}
