<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\API;

use MLocati\Nexi\XPayWeb\Build\Exception;
use RuntimeException;

class Entity
{
    private array $fields = [];
    private array $see = [];

    public function __construct(
        public string $name,
        public bool $addGetOrCreate,
        string $see,
        public bool $isQuery = false,
    ) {
        $this->addSee($see);
    }

    public function addField(Field $field): void
    {
        if (isset($this->fields[$field->name])) {
            throw new RuntimeException("Duplicated and incompatible field: {$field->name}");
        }
        $this->fields[$field->name] = $field;
    }

    /**
     * @return \MLocati\Nexi\XPayWeb\Build\API\Field[]
     */
    public function getFields(): array
    {
        return array_values($this->fields);
    }

    public function fieldsAre(array $otherFields): bool
    {
        $myFields = $this->getFields();
        $numFields = count($myFields);
        if (count($otherFields) !== $numFields) {
            return false;
        }
        $sorter = static fn (Field $a, Field $b): int => strcmp($a->name, $b->name);
        usort($myFields, $sorter);
        usort($otherFields, $sorter);
        foreach ($myFields as $index => $myField) {
            if (!$myField->isCompatibleWith($otherFields[$index])) {
                return false;
            }
        }

        return true;
    }

    public function isCompatibleWith(Entity $entity): bool
    {
        $myClone = clone $this;
        try {
            $myClone->merge($entity);
        } catch (Exception\IncompatibleEntity $_) {
            return false;
        } catch (Exception\IncompatibleField $_) {
            return false;
        }

        return true;
    }

    /**
     * @throws \MLocati\Nexi\XPayWeb\Build\Exception\IncompatibleEntity
     * @throws \MLocati\Nexi\XPayWeb\Build\Exception\IncompatibleField
     */
    public function merge(Entity $entity): void
    {
        $myFieldNames = array_keys($this->fields);
        $otherFieldNames = array_keys($entity->fields);
        sort($myFieldNames);
        sort($otherFieldNames);
        if ($myFieldNames !== $otherFieldNames) {
            throw new Exception\IncompatibleEntity();
        }
        $newFields = [];
        foreach ($this->fields as $key => $field) {
            $field = clone $field;
            $field->merge($entity->fields[$key]);
            $newFields[$key] = $field;
        }
        $this->fields = $newFields;
        $this->mergeMetadata($entity);
    }

    public function mergeMetadata(Entity $entity)
    {
        if ($entity->addGetOrCreate) {
            $this->addGetOrCreate = true;
        }
        if ($entity->isQuery) {
            $this->isQuery = true;
        }
        $this->addSeeList($entity->getSee());
    }

    public function addSee(string $value): void
    {
        if ($value !== '' && !in_array($value, $this->see, true)) {
            $this->see[] = $value;
            sort($this->see, SORT_STRING);
        }
    }

    /**
     * @param string[] $value
     */
    public function addSeeList(array $value): void
    {
        foreach ($value as $item) {
            $this->addSee($item);
        }
    }

    /**
     * @return string[]
     */
    public function getSee(): array
    {
        return $this->see;
    }

    public function isSomeFieldAlwaysRequired(): bool
    {
        foreach ($this->getFields() as $field) {
            if ($field->isAlwaysRequired()) {
                return true;
            }
        }

        return false;
    }
}
