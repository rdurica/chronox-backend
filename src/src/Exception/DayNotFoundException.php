<?php declare(strict_types=1);

namespace App\Exception;

use ApiPlatform\Metadata\ErrorResource;
use Exception;

/**
 * DayNotFoundException.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-01
 */
#[ErrorResource]
final class DayNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Day not found for the given UUID.');
    }
}
