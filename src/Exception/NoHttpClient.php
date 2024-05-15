<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Exception;

use MLocati\Nexi\XPayWeb\Exception;

/**
 * Exception thrown when no HTTP client is available.
 */
class NoHttpClient extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'No HTTP client available. Try enabling the cURL or the OpenSSL PHP extension.');
    }
}
