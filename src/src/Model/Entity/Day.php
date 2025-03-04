<?php declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Traits\CreatedAt;
use App\Model\Entity\Traits\Uuid;
use App\Model\Repository\DayRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Represents a user's daily entry in the system.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-10
 */
#[ORM\Entity(repositoryClass: DayRepository::class)]
#[ORM\UniqueConstraint(name: 'uq_user__entry_date', columns: ['user_id', 'entry_date'])]
class Day
{
    use CreatedAt;
    use Uuid;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTimeInterface $entryDate;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'entryDays')]
    private UserInterface $user;

    /** @var Collection<int, Task> */
    #[ORM\ManyToMany(targetEntity: Task::class, mappedBy: 'days')]
    private Collection $tasks;

    public function __construct()
    {
        $this->initializeUuid();
        $this->initializeCreatedAt();
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setUser(UserInterface $user): Day
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param Collection<int, Task> $tasks
     */
    public function setTasks(Collection $tasks): Day
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): Day
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->addDay($this);
        }

        return $this;
    }

    public function removeTask(Task $task): Day
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            $task->removeDay($this);
        }

        return $this;
    }
}
