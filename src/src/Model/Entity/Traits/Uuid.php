<?php declare(strict_types=1);

namespace App\Model\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

/**
 * Uuid.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-02
 */
#[ORM\Index(name: 'idx_uuid', columns: ['uuid'])]
trait Uuid
{
    protected function initializeUuid(): void
    {
        $this->uuid = SymfonyUuid::v4();
    }

    #[ORM\Column(type: UuidType::NAME, unique: true, options: ['default' => 'UUID()'])]
    private SymfonyUuid $uuid;

    public function getUuid(): ?SymfonyUuid
    {
        return $this->uuid;
    }
}