<?php declare(strict_types=1);

namespace App\Model\Dto;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SubTaskPost.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-04
 */
final class SubTaskPost
{
    #[Assert\Uuid]
    public Uuid $dayUuid;

    #[Assert\Uuid]
    public Uuid $taskUuid;

    #[Assert\Uuid]
    public Uuid $subTaskTypeUuid;

    #[Assert\Positive]
    public float $minutes;
}
