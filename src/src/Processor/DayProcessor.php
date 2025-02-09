<?php declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Day;
use App\Exception\DayAlreadyExistException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * DayDataPersister.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-09
 */
final class DayProcessor implements ProcessorInterface
{
    public function __construct(private Security $security, private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     * @throws DayAlreadyExistException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof Day) {
            $data->setUser($this->security->getUser());
        }

        try {
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
        catch (UniqueConstraintViolationException $e) {
            throw new DayAlreadyExistException();
        }
        catch (\Exception $e) {
            throw new BadRequestHttpException('An unexpected error occurred.', $e);
        }

        return $data;
    }
}
