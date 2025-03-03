<?php declare(strict_types=1);

namespace App\Model\Mapper;

use App\Model\Dto\Day as DayDto;
use App\Model\Dto\SubTask;
use App\Model\Dto\SubTaskType;
use App\Model\Dto\Task as TaskDto;
use App\Model\Entity\Day as DayEntity;
use App\Model\Entity\Task;
use DateTime;
use Symfony\Component\Uid\Uuid;

/**
 * Mapper for converting data into DayDto.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-01
 */
final class DayMapper
{
    public static function mapCreateDay(DayEntity $day): DayDto
    {
        $result = new DayDto();

        $result->uuid = $day->getUuid();
        $result->date = $day->getEntryDate()->format('Y-m-d');

        return $result;
    }

    /**
     * @param array{date: DateTime, uuid: Uuid, taskCount: int|null, totalMinutes: int|null} $day
     */
    public static function mapBaseDataArray(array $day): DayDto
    {
        $result = new DayDto();

        $result->uuid = $day['uuid'];
        $result->date = $day['date']->format('Y-m-d');
        $result->taskCount = $day['taskCount'] ?? 0;
        $result->totalMinutes = $day['totalMinutes'] ?? 0;

        return $result;
    }

    /**
     * @param array{date: DateTime, uuid: Uuid, taskCount: int|null, totalMinutes: int} $day
     * @param Task[]                                                                    $tasks
     *
     * @return DayDto
     */
    public static function mapDetailData(array $day, array $tasks): DayDto
    {
        $dayDto = self::mapBaseDataArray($day);

        foreach ($tasks as $task) {
            $taskDto = new TaskDto();
            $taskDto->uuid = $task->getUuid();
            $taskDto->title = $task->getTitle();
            $taskDto->finished = $task->isFinished();

            foreach ($task->getSubTasks() as $subTask) {
                $subTaskDto = new SubTask();
                $subTaskDto->uuid = $subTask->getUuid();
                $subTaskDto->minutes = $subTask->getMinutes();

                $subTaskTypeDto = new SubTaskType();
                $subTaskTypeDto->uuid = $subTask->getSubTaskType()->getUuid();
                $subTaskTypeDto->title = $subTask->getSubTaskType()->getTitle();

                $subTaskDto->type = $subTaskTypeDto;
                $taskDto->subTasks[] = $subTaskDto;
            }

            $dayDto->tasks[] = $taskDto;
        }

        return $dayDto;
    }
}
