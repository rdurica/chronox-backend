<?php declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


final class TaskProcessor implements ProcessorInterface
{
    public function __construct(private Security $security, private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof Task) {
            $data->setUser($this->security->getUser());
        }

        try {
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
        catch (Exception $e) {
            throw new BadRequestHttpException('An unexpected error occurred.', $e);
        }

        return $data;
    }
}
