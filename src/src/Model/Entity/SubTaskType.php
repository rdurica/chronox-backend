<?php declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Traits\CreatedAt;
use App\Model\Entity\Traits\Uuid;
use App\Model\Repository\SubTaskTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubTaskTypeRepository::class)]
class SubTaskType
{
    use CreatedAt;
    use Uuid;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    public function __construct()
    {
        $this->initializeUuid();
        $this->initializeCreatedAt();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): SubTaskType
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
