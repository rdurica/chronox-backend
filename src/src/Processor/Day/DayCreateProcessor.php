<?php declare(strict_types=1);

namespace App\Processor\Day;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Exception\DayAlreadyExistException;
use App\Model\Entity\Day;
use App\Model\Service\DayService;
use DateMalformedStringException;

/**
 * Custom processor for managing the creation of {@see Day} entries.
 *
 * This processor is used to handle the logic behind persisting a new `Day` entry,
 * ensuring that each entry is associated with the currently authenticated user.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-09
 */
final class DayCreateProcessor implements ProcessorInterface
{
    public function __construct(private DayService $dayService)
    {
    }

    /**
     * @inheritDoc
     * @throws DateMalformedStringException
     * @throws DayAlreadyExistException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return $this->dayService->create($data->date);
    }
}
