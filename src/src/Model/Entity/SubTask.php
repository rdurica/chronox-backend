<?php declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Repository\SubTaskRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SubTaskRepository::class)]
class SubTask
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['subTask:read', 'day:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['subTask:read', 'day:read', 'task:read'])]
    private DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: SubTaskType::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['subTask:read', 'day:read', 'task:read', 'task:addSubtask'])]
    private SubTaskType $subTaskType;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'subTasks')]
    #[ORM\JoinColumn(nullable: false)]
    private Task $task;

    #[ORM\Column(type: Types::FLOAT, options: ['default' => 0])]
    #[Groups(['task:read', 'task:write', 'day:read', 'day:list', 'task:addSubtask'])]
    private ?float $minutes = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'users')]
    private UserInterface $user;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getSubTaskType(): SubTaskType
    {
        return $this->subTaskType;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getMinutes(): ?float
    {
        return $this->minutes;
    }

    public function setCreatedAt(DateTime $createdAt): SubTask
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setSubTaskType(SubTaskType $subTaskType): SubTask
    {
        $this->subTaskType = $subTaskType;

        return $this;
    }

    public function setTask(Task $task): SubTask
    {
        $this->task = $task;

        return $this;
    }

    public function setMinutes(?float $minutes): SubTask
    {
        $this->minutes = $minutes;

        return $this;
    }

    public function setUser(UserInterface $user): SubTask
    {
        $this->user = $user;

        return $this;
    }
}
