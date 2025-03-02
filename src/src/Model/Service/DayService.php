<?php declare(strict_types=1);

namespace App\Model\Service;

use App\Exception\DayAlreadyExistException;
use App\Exception\DayNotFoundException;
use App\Model\Dto\Day;
use App\Model\Dto\Day as DayDto;
use App\Model\Entity\Day as DayEntity;
use App\Model\Mapper\DayMapper;
use App\Model\Repository\DayRepository;
use DateMalformedStringException;
use DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
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
        private Security $security
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
        $day = $this->dayRepository->findByUuid($user, $uuid);

        if($day ===  null) {
            throw new DayNotFoundException();
        }

        return DayMapper::mapArray($day);
    }

    public function getPaginatedData(int $page, int $itemsPerPage): array
    {
        $user = $this->security->getUser();
        $data = $this->dayRepository->getPaginatedData($user, $page, $itemsPerPage);

        $result = [];
        foreach ($data as $day) {
            $result[] = DayMapper::mapArray($day);
        }

        return $result;
    }
}
