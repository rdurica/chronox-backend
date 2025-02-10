<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Exception\DayAlreadyExistException;
use App\Processor\DayProcessor;
use App\Repository\DayRepository;
use App\State\DayStateProvider;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * Represents a user's daily entry in the system.
 *
 * This entity is used to store and manage daily records for users. Each entry is
 * uniquely identified by the combination of `user_id` and `entry_date` to prevent
 * duplicate entries for the same day.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-10
 */
#[ORM\Entity(repositoryClass: DayRepository::class)]
#[ORM\UniqueConstraint(name: 'user_entry_date_uq', columns: ['user_id', 'entry_date'])]
#[ApiResource(
    operations: [
        new Post(
            exceptionToStatus: [DayAlreadyExistException::class => 422],
            processor: DayProcessor::class
        ),
        new GetCollection(
            provider: DayStateProvider::class
        ),
        new Get(security: "is_granted('VIEW', object)"),
        new Delete(security: "is_granted('DELETE', object)"),
    ],
    normalizationContext: ['groups' => ['day:read']],
    denormalizationContext: ['groups' => ['day:write']],
    order: ['entryDate' => 'DESC'],
)]
class Day
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['day:read', 'day:write'])]
    private DateTimeInterface $entryDate;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['day:read'])]
    private DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'entryDays')]
    private UserInterface $user;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntryDate(): DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(DateTimeInterface $entryDate): static
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
