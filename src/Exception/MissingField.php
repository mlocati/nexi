<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Exception;

use MLocati\Nexi\XPayWeb\Exception;

/**
 * Exception thrown when a required field is missing.
 */
class MissingField extends Exception
{
    /**
     * @var string
     */
    private $field;

    public function __construct(string $field, string $message = '')
    {
        parent::__construct($message ?: "Missing required field: {$field}");
        $this->field = $field;
    }

    /**
     * Get the name of the missing field.
     */
    public function getField(): string
    {
        return $this->field;
    }
}
