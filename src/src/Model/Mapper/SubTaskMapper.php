<?php declare(strict_types=1);

namespace App\Model\Mapper;

use App\Model\Dto\SubTask as SubTaskDto;
use App\Model\Dto\SubTaskPatch;
use App\Model\Entity\SubTask;

/**
 * SubTaskMapper.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-04
 */
final class SubTaskMapper
{
    public static function mapPatchSubTask(SubTask $subTask): SubTaskPatch
    {
        $result = new SubTaskPatch();

        $result->uuid = $subTask->getUuid();
        $result->minutes = $subTask->getMinutes();

        return $result;
    }

    public static function mapPostSubTask(SubTask $subTask): SubTaskDto
    {
        $result = new SubTaskDto();

        $result->uuid = $subTask->getUuid();
        $result->minutes = $subTask->getMinutes();

        return $result;
    }
}
