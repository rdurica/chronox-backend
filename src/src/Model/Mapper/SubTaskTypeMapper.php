<?php declare(strict_types=1);

namespace App\Model\Mapper;

use App\Model\Dto\SubTaskType as SubTaskTypeDto;
use App\Model\Entity\SubTaskType;

/**
 * SubTaskTypeMapper.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-04
 */
final class SubTaskTypeMapper
{
    public static function map(SubTaskType $subTaskType): SubTaskTypeDto
    {
        $result = new SubTaskTypeDto();
        $result->uuid = $subTaskType->getUuid();
        $result->title = $subTaskType->getTitle();

        return $result;
    }
}
