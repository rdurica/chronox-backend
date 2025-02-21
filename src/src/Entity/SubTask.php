<?php

namespace App\Entity;

use App\Repository\SubTaskRepository;
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
    #[Groups(['subTask:read', 'day:read', 'task:read'])]
    private SubTaskType $subTaskType;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'subTasks')]
    #[ORM\JoinColumn(nullable: false)]
    private Task $task;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'users')]
    private UserInterface $user;

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



}
