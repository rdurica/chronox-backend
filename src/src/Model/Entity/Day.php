<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Repository\DayRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Represents a user's daily entry in the system.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-10
 */
#[ORM\Entity(repositoryClass: DayRepository::class)]
#[ORM\UniqueConstraint(name: 'user_entry_date_uq', columns: ['user_id', 'entry_date'])]
#[ORM\Index(name: 'idx_uuid', columns: ['uuid'])]
class Day
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: true, options: ['default' => 'UUID()'])]
    private ?Uuid $uuid;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTimeInterface $entryDate;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'entryDays')]
    private UserInterface $user;

    #[ORM\ManyToMany(targetEntity: Task::class, mappedBy: 'days')]
    private Collection $tasks;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->tasks = new ArrayCollection();
        $this->uuid = Uuid::v7();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUuid(?Uuid $uuid): Day
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function setEntryDate(DateTimeInterface $entryDate): Day
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    public function getEntryDate(): DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setCreatedAt(DateTime $createdAt): Day
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setUser(UserInterface $user): Day
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setTasks(Collection $tasks): Day
    {
        $this->tasks = $tasks;

        return $this;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): Day
    {
        $this->tasks->add($task);

        return $this;
    }

    public function removeTask(Task $task): Day
    {
        $this->tasks->removeElement($task);

        return $this;
    }
}
