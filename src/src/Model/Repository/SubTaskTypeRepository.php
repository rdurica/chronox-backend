<?php

namespace App\Model\Repository;

use App\Exception\SubTaskTypeNotFoundException;
use App\Model\Entity\SubTaskType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<SubTaskType>
 */
class SubTaskTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubTaskType::class);
    }

    /**
     * @throws SubTaskTypeNotFoundException
     */
    public function fetchByUuid(Uuid $uuid): SubTaskType
    {
        /** @var ?SubTaskType $result */
        $result = $this->createQueryBuilder('stt')
            ->where('stt.uuid = :uuid')
            ->setParameter('uuid', $uuid->toBinary())
            ->getQuery()
            ->getOneOrNullResult();

        if ($result === null) {
            throw new SubTaskTypeNotFoundException();
        }

        return $result;
    }
}
