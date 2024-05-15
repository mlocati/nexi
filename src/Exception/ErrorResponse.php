<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Exception;

use MLocati\Nexi\XPayWeb\Exception;

/**
 * Exception thrown when an HTTP request can't be performed.
 * Use the getCode() method to retrieve the HTTP response code (usually between 400 and 599).
 */
class ErrorResponse extends Exception
{
    public function __construct(int $httpCode, string $message)
    {
        parent::__construct($message, $httpCode);
    }
}
