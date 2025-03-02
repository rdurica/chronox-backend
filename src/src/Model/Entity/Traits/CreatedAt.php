<?php declare(strict_types=1);

namespace App\Model\Entity\Traits;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * CreatedAt.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-02
 */
trait CreatedAt
{
    protected function initializeCreatedAt(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTimeImmutable $createdAt;

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}