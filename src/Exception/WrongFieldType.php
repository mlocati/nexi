<?php

declare(strict_types=1);

namespace MLocati\Nexi\Exception;

use MLocati\Nexi\Exception;
use stdClass;

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

    private $actualValue;

    public function __construct(string $field, string $expectedType, $actualValue, string $message = '')
    {
        $this->field = $field;
        $this->expectedType = $expectedType;
        $this->actualValue = $actualValue;
        parent::__construct($message ?: "The field {$field} has the wrong type (expected: {$expectedType}, found: {$this->getActualType()})");
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
        $type = gettype($this->actualValue);

        return $type !== 'object' || $this->actualValue instanceof stdClass ? $type : get_class($this->actualValue);
    }

    /**
     * Get the actual value of the field value.
     */
    public function getActualValue(): string
    {
        return $this->actualValue;
    }
}
