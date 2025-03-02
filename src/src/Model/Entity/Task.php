<?php declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Traits\CreatedAt;
use App\Model\Entity\Traits\UpdatedAt;
use App\Model\Entity\Traits\Uuid;
use App\Model\Repository\TaskRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    use CreatedAt;
    use UpdatedAt;
    use Uuid;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(options: ['default' => false])]
    private bool $finished;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => null])]
    private DateTime $finishedAt;

    #[ORM\ManyToMany(targetEntity: Day::class, inversedBy: 'tasks')]
    #[ORM\JoinTable(name: 'day_tasks')]
    private Collection $days;

    #[ORM\OneToMany(targetEntity: SubTask::class, mappedBy: 'task')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $subTasks;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private UserInterface $user;

    public function __construct()
    {
        $this->initializeUuid();
        $this->initializeCreatedAt();
        $this->days = new ArrayCollection();
        $this->subTasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): Task
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setFinished(bool $finished): Task
    {
        $this->finished = $finished;

        return $this;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setFinishedAt(DateTime $finishedAt): Task
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getFinishedAt(): DateTime
    {
        return $this->finishedAt;
    }

    public function setDays(Collection $days): Task
    {
        $this->days = $days;

        return $this;
    }

    public function getDays(): Collection
    {
        return $this->days;
    }

    public function addDay(Day $day): Task
    {
        if (!$this->days->contains($day)) {
            $this->days->add($day);
            $day->addTask($this);
        }

        return $this;
    }

    public function removeDay(Day $day): Task
    {
        if ($this->days->contains($day)) {
            $this->days->removeElement($day);
            $day->removeTask($this);
        }

        return $this;
    }

    public function setSubTasks(Collection $subTasks): Task
    {
        $this->subTasks = $subTasks;

        return $this;
    }

    public function getSubTasks(): Collection
    {
        return $this->subTasks;
    }

    public function addSubTask(SubTask $subTask): Task
    {
        if (!$this->subTasks->contains($subTask)) {
            $this->subTasks[] = $subTask;
            $subTask->setTask($this);
        }

        return $this;
    }

    public function setUser(UserInterface $user): Task
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
