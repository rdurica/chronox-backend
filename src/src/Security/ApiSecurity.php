<?php declare(strict_types=1);

namespace App\Security;

use LogicException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * ApiSecurity.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-03
 */
final class ApiSecurity
{
    public function __construct(private Security $security)
    {
    }

    public function getUser(): UserInterface
    {
        $user = $this->security->getUser();
        if ($user === null) {
            throw new LogicException('User is not authenticated.');
        }

        return $user;
    }
}
