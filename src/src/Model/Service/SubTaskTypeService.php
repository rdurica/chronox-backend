<?php declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Dto\SubTaskType;
use App\Model\Mapper\SubTaskTypeMapper;
use App\Model\Repository\SubTaskTypeRepository;

/**
 * SubTaskTypeService.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-04
 */
final class SubTaskTypeService
{
    public function __construct(private SubTaskTypeRepository $subtaskTypeRepository)
    {
    }

    /**
     * @return SubTaskType[]
     */
    public function getSubTaskTypes(): array
    {
        $result = [];
        $subTaskTypes = $this->subtaskTypeRepository->findAll();

        foreach ($subTaskTypes as $subTaskType) {
            $result[] = SubTaskTypeMapper::map($subTaskType);
        }

        return $result;
    }
}
