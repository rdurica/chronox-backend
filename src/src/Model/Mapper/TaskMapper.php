<?php declare(strict_types=1);

namespace App\Model\Mapper;

use App\Model\Dto\Task as TaskDto;
use App\Model\Entity\Task as TaskEntity;

/**
 * TaskMapper.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-03
 */
final class TaskMapper
{
    public static function mapCreateTask(TaskEntity $task): TaskDto
    {
        $result = new TaskDto();

        $result->uuid = $task->getUuid();
        $result->title = $task->getTitle();
        $result->finished = $task->isFinished();

        return $result;
    }
}
