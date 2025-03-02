<?php

namespace App\Model\Entity;

use App\Model\Repository\TaskRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
//#[ApiResource(
//    operations: [
//        new Post(
//            processor: TaskProcessor::class
//        ),
//        new GetCollection(
//            uriTemplate: '/tasks/opened',
//            normalizationContext: ['groups' => ['task:opened']],
//            denormalizationContext: ['groups' => ['task:write']],
//            provider: TaskOpenedProvider::class,
//        ),
//        new GetCollection(
//            normalizationContext: ['groups' => ['task:list']],
//            denormalizationContext: ['groups' => ['task:write']],
//            provider: TaskStateProvider::class,
//        ),
//        new Get(
//            normalizationContext: ['groups' => ['task:read']],
//            denormalizationContext: ['groups' => ['task:write']],
//            security: "is_granted('VIEW', object)",
//        ),
//        new Delete(security: "is_granted('DELETE', object)"),
//        new Patch(
//            uriTemplate: '/tasks/addSubtask',
//            normalizationContext: ['groups' => ['task:addSubtask']],
//            security: "is_granted('EDIT', object)",
//            input: AddSubTask::class,
//            output: null,
//            processor: TaskAddSubTaskProcessor::class,
//        ),
//        new Patch(
//            uriTemplate: '/tasks/{id}/finish',
//            normalizationContext: ['groups' => ['task:read']],
//            denormalizationContext: ['groups' => ['task:write']],
//            security: "is_granted('EDIT', object)",
//            input: false,
//            processor: TaskFinishProcessor::class,
//        ),
//    ],
//    order: ['id' => 'ASC'],
//)]
#[ORM\Index(name: 'idx_uuid', columns: ['uuid'])]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['task:read', 'task:list', 'day:read', 'day:list', 'task:opened'])]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: true, options: ['default' => 'UUID()'])]
    private ?Uuid $uuid;

    #[ORM\Column(length: 255)]
    #[Groups(['task:read', 'task:list', 'task:write', 'day:read', 'task:opened'])]
    private ?string $name = null;

    #[ORM\Column(options: ['default' => false])]
    #[Groups(['task:read', 'task:list', 'day:read'])]
    private bool $finished = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['task:read', 'task:list', 'day:read'])]
    private DateTime $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => null])]
    #[Groups(['task:read', 'task:list', 'day:read'])]
    private DateTime $finishedAt;

    #[ORM\ManyToMany(targetEntity: Day::class, inversedBy: 'tasks')]
    #[ORM\JoinTable(name: 'day_tasks')]
    #[Groups(['task:read'])]
    private Collection $days;

    #[ORM\OneToMany(targetEntity: SubTask::class, mappedBy: 'task')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['day:read', 'task:read', 'day:list'])]
    private Collection $subTasks;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private UserInterface $user;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->days = new ArrayCollection();
        $this->subTasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): static
    {
        $this->finished = $finished;

        return $this;
    }

    public function setUser(UserInterface $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): ?UserInterface
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

    public function setFinishedAt(DateTime $finishedAt): static
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getFinishedAt(): DateTime
    {
        return $this->finishedAt;
    }

    public function getDays(): ArrayCollection
    {
        return $this->days;
    }

    public function getSubTasks(): Collection
    {
        return $this->subTasks;
    }

    public function addSubTask(SubTask $subTask): self
    {
        if (!$this->subTasks->contains($subTask)) {
            $this->subTasks[] = $subTask;
            $subTask->setTask($this);
        }

        return $this;
    }
}
