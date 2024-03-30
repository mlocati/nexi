<?php

declare(strict_types=1);

namespace MLocati\Nexi;

use Closure;
use JsonSerializable;

abstract class Entity implements JsonSerializable
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = [];
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     *
     * @return array|\stdClass
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->data === [] ? new \stdClass() : $this->data;
    }

    protected function _getRawData(): array
    {
        return $this->data;
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
                $type = gettype($value);
                if ($type !== 'string') {
                    throw new Exception\WrongFieldType($fieldName, 'string', $type);
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
                $type = gettype($value);
                if ($type !== 'integer') {
                    throw new Exception\WrongFieldType($fieldName, 'integer', $type);
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
        $initialException = null;
        try {
            return $this->_get($fieldName, ['boolean'], $required);
        } catch (Exception\WrongFieldType $x) {
            if ($allow01 === false || $x->getActualType() !== 'integer') {
                throw $x;
            }
            $initialException = $x;
        }
        if ($allow01) {
            $int = $this->_get($fieldName, ['integer'], true);
            if ($int === 0) {
                return false;
            }
            if ($int === 1) {
                return true;
            }
        }

        throw $initialException;
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
                $type = gettype($value);
                if ($type === 'boolean') {
                    return $value;
                }
                if ($allow01 && $type === 'integer') {
                    if ($value === 0) {
                        return false;
                    }
                    if ($value === 1) {
                        return true;
                    }
                }
                throw new Exception\WrongFieldType($fieldName, 'boolean', $type);
            }
        );
    }

    /**
     * @throws \MLocati\Nexi\Exception\MissingField
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    protected function _getEntity(string $fieldName, string $className, bool $required = false): ?Entity
    {
        $value = $this->_get($fieldName, ['array', 'object'], $required);
        if ($value === null) {
            return null;
        }
        if (is_array($value)) {
            $value = new $className($value);
            $this->data[$fieldName] = $value;

            return $value;
        }
        if ($value instanceof $className) {
            return $value;
        }
        throw new Exception\WrongFieldType($fieldName, $className, get_class($value));
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
                $type = gettype($value);
                if ($type === 'array') {
                    return new $className($value);
                }
                if ($type === 'object') {
                    if ($value instanceof $className) {
                        return $value;
                    }
                    throw new Exception\WrongFieldType($fieldName, $className, get_class($value));
                }
                throw new Exception\WrongFieldType($fieldName, 'object|array', $type);
            }
        );
        if ($array !== null) {
            $this->data[$fieldName] = $array;
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
                $type = gettype($value);
                if (!in_array($type, ['array', 'object'], true)) {
                    throw new Exception\WrongFieldType($fieldName, 'object|array', $type);
                }

                return $value;
            }
        );
    }

    /**
     * @return $this
     */
    protected function _unset(string $fieldName): self
    {
        unset($this->data[$fieldName]);

        return $this;
    }

    /**
     * @return $this
     */
    protected function _set(string $fieldName, $value): self
    {
        $this->data[$fieldName] = $value;

        return $this;
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
                if (!is_a($instance, $className, true)) {
                    throw new Exception\WrongFieldType($fieldName, $className, get_class($instance));
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
        $type = gettype($value);
        if (!in_array($type, ['array', 'object'], true)) {
            throw new Exception\WrongFieldType($fieldName, 'array|object', $type);
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
        $value = $this->data[$fieldName] ?? null;
        if ($value === null) {
            if ($required) {
                throw new Exception\MissingField($fieldName);
            }

            return null;
        }
        $type = gettype($value);
        if (!in_array($type, $types, true)) {
            throw new Exception\WrongFieldType($fieldName, implode('|', $types), $type);
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
     */
    private function _setArray(string $fieldName, array $types, array $value, ?Closure $callback = null): ?array
    {
        array_map(
            static function ($item) use ($fieldName, $types, $callback) {
                $type = gettype($item);
                if (!in_array($type, $types, true)) {
                    throw new Exception\WrongFieldType($fieldName, implode('|', $types), $type);
                }
                if ($callback !== null) {
                    $callback($item);
                }
            },
            $value
        );

        return $this->set($fieldName, array_values($value));
    }
}
