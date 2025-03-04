<?php declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Traits\CreatedAt;
use App\Model\Entity\Traits\UpdatedAt;
use App\Model\Entity\Traits\Uuid;
use App\Model\Repository\SubTaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: SubTaskRepository::class)]
#[ORM\UniqueConstraint(name: 'uq_sub_task_type__day__task', columns: ['sub_task_type_id', 'day_id', 'task_id'])]
class SubTask
{
    use CreatedAt;
    use UpdatedAt;
    use Uuid;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: SubTaskType::class)]
    #[ORM\JoinColumn(nullable: false)]
    private SubTaskType $subTaskType;

    #[ORM\ManyToOne(targetEntity: Day::class, inversedBy: 'days')]
    #[ORM\JoinColumn(nullable: false)]
    private Day $day;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'subTasks')]
    #[ORM\JoinColumn(nullable: false)]
    private Task $task;

    #[ORM\Column(type: Types::FLOAT, options: ['default' => 0])]
    private float $minutes;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'users')]
    private UserInterface $user;

    public function __construct()
    {
        $this->initializeUuid();
        $this->initializeCreatedAt();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setSubTaskType(SubTaskType $subTaskType): SubTask
    {
        $this->subTaskType = $subTaskType;

        return $this;
    }

    public function getSubTaskType(): SubTaskType
    {
        return $this->subTaskType;
    }

    public function setTask(Task $task): SubTask
    {
        $this->task = $task;

        return $this;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setMinutes(float $minutes): SubTask
    {
        $this->minutes = $minutes;

        return $this;
    }

    public function getMinutes(): float
    {
        return $this->minutes;
    }

    public function setUser(UserInterface $user): SubTask
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
