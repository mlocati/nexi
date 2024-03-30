<?php

declare(strict_types=1);

namespace MLocati\Nexi\Exception;

use MLocati\Nexi\Exception;

/**
 * Exception thrown when a field is not of an expected type.
 */
class WrongFieldType extends Exception
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $expectedType;

    /**
     * @var string
     */
    private $actualType;

    public function __construct(string $field, string $expectedType, string $actualType, string $message = '')
    {
        parent::__construct($message ?: "The field {$field} has the wrong type (expected: {$expectedType}, found: {$actualType})");
        $this->field = $field;
        $this->expectedType = $expectedType;
        $this->actualType = $actualType;
    }

    /**
     * Get the name of the field containing the wrong value.
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * Get the type we are expecting (multiple values separated by |).
     */
    public function getExpectedType(): string
    {
        return $this->expectedType;
    }

    /**
     * Get the actual type of the field value.
     */
    public function getActualType(): string
    {
        return $this->actualType;
    }
}
