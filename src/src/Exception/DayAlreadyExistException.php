<?php declare(strict_types=1);

namespace App\Exception;

use ApiPlatform\Metadata\ErrorResource;
use Exception;

/**
 * DayEntryAlreadyExistException.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-02-09
 */
#[ErrorResource]
final class DayAlreadyExistException extends Exception
{
    public function __construct()
    {
        parent::__construct('Entry for this day is already created');
    }
}
