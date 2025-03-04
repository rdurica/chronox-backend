<?php declare(strict_types=1);

namespace App\Model\Dto;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Task.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-03
 */
final class SubTask
{    /** @var Uuid Day UUID. */
    #[Assert\Uuid]
    #[Groups(['day:get', 'subTask:postResult'])]
    public Uuid $uuid;

    #[Groups(['day:get', 'subTask:postResult'])]
    public float $minutes;

    #[Groups(['day:get'])]
    public SubTaskType $type;
}
