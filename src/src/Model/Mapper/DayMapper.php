<?php declare(strict_types=1);

namespace App\Model\Mapper;

use App\Model\Dto\Day as DayDto;
use App\Model\Entity\Day as DayEntity;
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
     * @param array{date: DateTime, uuid: Uuid, taskCount: int, totalMinutes: int} $day
     */
    public static function mapArray(array $day): DayDto
    {
        $result = new DayDto();

        $result->uuid         = $day['uuid'];
        $result->date         = $day['date']->format('Y-m-d');
        $result->taskCount    = $day['taskCount'] ?? 0;
        $result->totalMinutes = $day['totalMinutes'] ?? 0;

        return $result;
    }
}
