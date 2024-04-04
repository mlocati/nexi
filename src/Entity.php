<?php

declare(strict_types=1);

namespace MLocati\Nexi;

use Closure;
use JsonSerializable;
use stdClass;

abstract class Entity implements JsonSerializable
{
    /**
     * @var \stdClass
     */
    private $data;

    public function __construct(?stdClass $data = null)
    {
        $this->data = $data ?? new stdClass();
    }

    public function __clone()
    {
        $this->data = unserialize(serialize($this->data));
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize(): stdClass
    {
        return $this->data;
    }

    /**
     * Check for missing required fields.
     *
     * @param string $method the method being invoked
     * @param string $case 'request' or 'response'
     *
     * @throws \MLocati\Nexi\Exception\MissingField
     */
    public function checkRequiredFields(string $method, string $case): void
    {
        $this->checkRequiredFieldsWithPrefix($method, $case, '');
    }

    /**
     * @return string[]
     */
    abstract protected function getRequiredFields(): array;

    protected function _getRawData(): stdClass
    {
        return $this->data;
    }

    /**
     * @return $this
     */
    protected function _set(string $fieldName, $value): self
    {
        $this->data->{$fieldName} = $value;

        return $this;
    }

    /**
     * @return $this
     */
    protected function _unset(string $fieldName): self
    {
        unset($this->data->{$fieldName});

        return $this;
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    protected function _getString(string $fieldName, bool $required = false): ?string
    {
        return $this->_get($fieldName, ['string'], $required);
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return string[]|null
     */
    protected function _getStringArray(string $fieldName, bool $required = false): ?array
    {
        return $this->_getArray(
            $fieldName,
            $required,
            static function ($value) use ($fieldName): string {
                if (gettype($value) !== 'string') {
                    throw new Exception\WrongFieldType($fieldName, 'string', $value);
                }

                return $value;
            }
        );
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    protected function _getInt(string $fieldName, bool $required = false): ?int
    {
        return $this->_get($fieldName, ['integer'], $required);
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return int[]|null
     */
    protected function _getIntArray(string $fieldName, bool $required = false): ?array
    {
        return $this->_getArray(
            $fieldName,
            $required,
            static function ($value) use ($fieldName): int {
                if (gettype($value) !== 'integer') {
                    throw new Exception\WrongFieldType($fieldName, 'integer', $value);
                }

                return $value;
            }
        );
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    protected function _getBool(string $fieldName, bool $allow01 = false, bool $required = false): ?bool
    {
        try {
            return $this->_get($fieldName, ['boolean'], $required);
        } catch (Exception\WrongFieldType $x) {
            if ($allow01) {
                if ($x->getActualValue() === 0) {
                    return false;
                }
                if ($x->getActualValue() === 1) {
                    return true;
                }
            }
            throw $x;
        }
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return bool[]|null
     */
    protected function _getBoolArray(string $fieldName, bool $allow01 = false, bool $required = false): ?array
    {
        return $this->_getArray(
            $fieldName,
            $required,
            static function ($value) use ($fieldName, $allow01): bool {
                if (gettype($value) === 'boolean') {
                    return $value;
                }
                if ($allow01) {
                    if ($value === 0) {
                        return false;
                    }
                    if ($value === 1) {
                        return true;
                    }
                }
                throw new Exception\WrongFieldType($fieldName, 'boolean', $value);
            }
        );
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    protected function _getEntity(string $fieldName, string $className, bool $required = false): ?Entity
    {
        $value = $this->_get($fieldName, ['object'], $required);
        if ($value === null) {
            return null;
        }
        if ($value instanceof stdClass) {
            $value = new $className($value);
            $this->_set($fieldName, $value);

            return $value;
        }
        if ($value instanceof $className) {
            return $value;
        }
        throw new Exception\WrongFieldType($fieldName, $className, $value);
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\Entity[]|null
     */
    protected function _getEntityArray(string $fieldName, string $className, bool $required = false): ?array
    {
        $array = $this->_getArray(
            $fieldName,
            $required,
            static function ($value) use ($fieldName, $className): Entity {
                if ($value instanceof $className) {
                    return $value;
                }
                if ($value instanceof stdClass) {
                    return new $className($value);
                }
                throw new Exception\WrongFieldType($fieldName, is_object($value) ? $className : 'object', $value);
            }
        );
        if ($array !== null) {
            $this->_set($fieldName, $array);
        }

        return $array;
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return object|array|null
     */
    protected function _getCustomObject(string $fieldName, bool $required = false)
    {
        return $this->_get($fieldName, ['array', 'object'], $required);
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return object[]|array[]|null
     */
    protected function _getCustomObjectArray(string $fieldName, bool $required = false): ?array
    {
        return $this->_getArray(
            $fieldName,
            $required,
            static function ($value) use ($fieldName) {
                if (!in_array(gettype($value), ['array', 'object'], true)) {
                    throw new Exception\WrongFieldType($fieldName, 'object|array', $value);
                }

                return $value;
            }
        );
    }

    /**
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return $this
     */
    protected function _setBoolArray(string $fieldName, array $value): self
    {
        return $this->_setArray($fieldName, ['boolean'], $value);
    }

    /**
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return $this
     */
    protected function _setIntArray(string $fieldName, array $value): self
    {
        return $this->_setArray($fieldName, ['integer'], $value);
    }

    /**
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return $this
     */
    protected function _setStringArray(string $fieldName, array $value): self
    {
        return $this->_setArray($fieldName, ['string'], $value);
    }

    /**
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return $this
     */
    protected function _setEntityArray(string $fieldName, string $className, array $value): self
    {
        return $this->_setArray(
            $fieldName,
            ['object'],
            $value,
            static function (object $instance) use ($fieldName, $className): void {
                if (!$instance instanceof $className) {
                    throw new Exception\WrongFieldType($fieldName, $className, $instance);
                }
            }
        );
    }

    /**
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return $this
     */
    protected function _setCustomObject(string $fieldName, $value): self
    {
        if (!in_array(gettype($value), ['array', 'object'], true)) {
            throw new Exception\WrongFieldType($fieldName, 'array|object', $value);
        }

        return $this->_set($fieldName, $value);
    }

    /**
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return $this
     */
    protected function _setCustomObjectArray(string $fieldName, array $value): self
    {
        return $this->_setArray($fieldName, ['array', 'object'], $value);
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    private function _get(string $fieldName, array $types, bool $required)
    {
        $value = $this->data->{$fieldName} ?? null;
        if ($value === null) {
            if ($required) {
                throw new Exception\MissingField($fieldName);
            }

            return null;
        }
        if (!in_array(gettype($value), $types, true)) {
            throw new Exception\WrongFieldType($fieldName, implode('|', $types), $value);
        }

        return $value;
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    private function _getArray(string $fieldName, bool $required, Closure $callback): ?array
    {
        $values = $this->_get($fieldName, ['array'], $required);
        if ($values === null) {
            return $values;
        }

        return array_map($callback, $values);
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     *
     * @return $this
     */
    private function _setArray(string $fieldName, array $types, array $value, ?Closure $callback = null): self
    {
        array_map(
            static function ($item) use ($fieldName, $types, $callback) {
                if (!in_array(gettype($item), $types, true)) {
                    throw new Exception\WrongFieldType($fieldName, implode('|', $types), $item);
                }
                if ($callback !== null) {
                    $callback($item);
                }
            },
            $value
        );

        return $this->_set($fieldName, array_values($value));
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     */
    private function checkRequiredFieldsWithPrefix(string $method, string $case, string $prefix): void
    {
        foreach ($this->getRequiredFields() as $fieldName => $methods) {
            if ($methods !== true) {
                if (!isset($methods[$method])) {
                    continue;
                }
                if ($methods[$method] !== true && $methods[$method] !== $case) {
                    continue;
                }
            }
            $prefixedFieldName = $prefix . $fieldName;
            $getter = 'get' . ucfirst($fieldName);
            $value = $this->{$getter}();
            if ($value === null) {
                throw new Exception\MissingField($prefixedFieldName);
            }
            if ($value instanceof Entity) {
                $value->checkRequiredFieldsWithPrefix($method, $case, $prefixedFieldName . '.');
            } elseif (is_array($value)) {
                foreach ($value as $index => $item) {
                    if ($item instanceof Entity) {
                        $item->checkRequiredFieldsWithPrefix($method, $case, $prefixedFieldName . "[{$index}].");
                    }
                }
            }
        }
    }
}
