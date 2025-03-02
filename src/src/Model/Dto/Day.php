<?php declare(strict_types=1);

namespace App\Model\Dto;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a day's summary with associated metadata.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-02
 */
final class Day
{
    /** @var Uuid Day UUID. */
    #[Assert\Uuid]
    #[Groups(['day:postResult', 'day:get', 'day:list'])]
    public Uuid $uuid;

    /** @var string The date of the day in Y-m-d format. */
    #[Assert\Date]
    #[Groups(['day:post', 'day:get', 'day:list'])]
    public string $date;

    /** @var int Total tasks for day. */
    #[Groups(['day:get', 'day:list'])]
    public int $taskCount;

    /** @var float Total spent time. */
    #[Groups(['day:get', 'day:list'])]
    public float $totalMinutes;
}
