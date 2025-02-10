<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Day;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Defines access control rules for the {@see Day} entity.
 *
 * This voter is responsible for determining whether a user has permission
 * to view, or delete a `Day` entry. It ensures that users can only
 * manage their own daily entries.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-10
 */
final class DayVoter extends Voter
{
    public const VIEW = 'VIEW';
    public const DELETE = 'DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::DELETE]) && $subject instanceof Day;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Day $day */
        $day = $subject;
        if($day->getUser() === $user) {
            return true;
        }

        return false;
    }
}
