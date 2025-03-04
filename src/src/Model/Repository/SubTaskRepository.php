<?php

namespace App\Model\Repository;

use App\Exception\SubTaskNotFoundException;
use App\Model\Entity\SubTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<SubTask>
 */
class SubTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubTask::class);
    }

    /**
     * @throws SubTaskNotFoundException
     */
    public function fetchByUuid(UserInterface $user, Uuid $uuid): SubTask
    {
        /** @var SubTask|null $data */
        $data = $this->createQueryBuilder('s')
            ->where('s.user = :user')
            ->andWhere('s.uuid = :uuid')
            ->setParameter('user', $user)
            ->setParameter('uuid', $uuid->toBinary())
            ->getQuery()
            ->getOneOrNullResult();

        if ($data === null) {
            throw new SubTaskNotFoundException();
        }

        return $data;
    }
}
