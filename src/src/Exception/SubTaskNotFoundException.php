<?php declare(strict_types=1);

namespace App\Exception;

use ApiPlatform\Metadata\ErrorResource;
use Exception;

/**
 * SubTaskNotFoundException.
 *
 * @copyright Copyright (c) 2025, Robert Durica
 * @since     2025-03-04
 */
#[ErrorResource]
final class SubTaskNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('SubTask not found for the given UUID.');
    }
}
