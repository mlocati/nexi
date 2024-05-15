<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Exception\ErrorResponse;

use MLocati\Nexi\XPayWeb\Entity\Errors;
use MLocati\Nexi\XPayWeb\Exception\ErrorResponse;

/**
 * Exception thrown when an HTTP request can't be performed, with detailed errors.
 */
class Detailed extends ErrorResponse
{
    /**
     * @var \MLocati\Nexi\XPayWeb\Entity\Errors
     */
    private $errors;

    public function __construct(int $httpCode, string $message, Errors $errors)
    {
        parent::__construct($httpCode, $message);
        $this->errors = $errors;
    }

    /**
     * Get the HTTP response code (usually between 400 and 599).
     */
    public function getErrors(): Errors
    {
        return $this->errors;
    }
}
