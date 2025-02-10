<?php declare(strict_types=1);

namespace App\Exception;

use ApiPlatform\Metadata\ErrorResource;
use Exception;

/**
 * Exception thrown when a user attempts to create a duplicate day entry.
 *
 * This exception is triggered when a user tries to create a `Day` record
 * for a date that already exists in the database. The system enforces
 * uniqueness per user to prevent duplicate daily entries.
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
