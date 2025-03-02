<?php declare(strict_types=1);

namespace App\Model\Entity\Traits;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * CreatedAt.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-02
 */
#[ORM\HasLifecycleCallbacks]
trait UpdatedAt
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTime $updatedAt;

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->updatedAt = new DateTime();
    }
}