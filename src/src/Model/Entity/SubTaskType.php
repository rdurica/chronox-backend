<?php

namespace App\Model\Entity;

use App\Model\Repository\SubTaskTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SubTaskTypeRepository::class)]
class SubTaskType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['subTask:read', 'day:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['subTask:read', 'day:read'])]
    private ?string $name = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }


}
