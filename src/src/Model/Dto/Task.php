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
final class Task
{
    /** @var Uuid Day UUID. */
    #[Assert\Uuid]
    #[Groups(['day:get'])]
    public Uuid $uuid;

    #[Groups(['day:get'])]
    public string $title;

    #[Groups(['day:get'])]
    public bool $finished;

    /** @var SubTask[] */
    #[Groups(['day:get'])]
    public array $subTasks = [];
}
