<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use App\Repository\DayRepository;
use Symfony\Bundle\SecurityBundle\Security;

class DayStateProvider implements ProviderInterface
{
    public function __construct(private DayRepository $dayRepository, private Security $security)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if (!$user) {
            return [];
        }

        $page = $context['filters']['page'] ?? 1;
        $itemsPerPage = $context['filters']['itemsPerPage'] ?? 20;

        return $this->dayRepository->getPaginator($user, (int) $page, (int) $itemsPerPage);
    }
}
