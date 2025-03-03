<?php declare(strict_types=1);

namespace App\Model\Service;

use App\Exception\DayAlreadyExistException;
use App\Exception\DayNotFoundException;
use App\Model\Dto\Day;
use App\Model\Entity\Day as DayEntity;
use App\Model\Mapper\DayMapper;
use App\Model\Repository\DayRepository;
use App\Model\Repository\TaskRepository;
use App\Security\ApiSecurity;
use DateMalformedStringException;
use DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

/**
 * DayService.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-01
 */
final class DayService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private DayRepository $dayRepository,
        private TaskRepository $taskRepository,
        private ApiSecurity $security
    )
    {
    }

    /**
     * @throws DateMalformedStringException
     * @throws DayAlreadyExistException
     */
    public function create(string $date): Day
    {
        $user = $this->security->getUser();

        $day = new DayEntity();
        $day->setUser($user);
        $day->setEntryDate(new DateTime($date));

        try {
            $this->entityManager->persist($day);
            $this->entityManager->flush();
        }
        catch (UniqueConstraintViolationException) {
            throw new DayAlreadyExistException();
        }

        return DayMapper::mapCreateDay($day);
    }

    /**
     * @throws DayNotFoundException
     */
    public function getByUuid(Uuid $uuid): Day
    {
        $user = $this->security->getUser();
        $day = $this->dayRepository->findBaseData($user, $uuid);

        if($day ===  null) {
            throw new DayNotFoundException();
        }

        return DayMapper::mapBaseDataArray($day);
    }

    /**
     * @throws DayNotFoundException
     */
    public function getDetail(Uuid $uuid): Day
    {
        $user = $this->security->getUser();
        $day = $this->dayRepository->findBaseData($user, $uuid);

        if($day ===  null) {
            throw new DayNotFoundException();
        }

        $tasks = $this->taskRepository->findByDateId($day['id']);

        return DayMapper::mapDetailData($day, $tasks);
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     *
     * @return Day[]
     */
    public function getPaginatedData(int $page, int $itemsPerPage): array
    {
        $user = $this->security->getUser();
        $data = $this->dayRepository->getPaginatedData($user, $page, $itemsPerPage);

        $result = [];
        foreach ($data as $day) {
            $result[] = DayMapper::mapBaseDataArray($day);
        }

        return $result;
    }
}
