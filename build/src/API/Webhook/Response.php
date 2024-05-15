<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\API\Webhook;

use MLocati\Nexi\XPayWeb\Build\API\Field;
use RuntimeException;

class Response
{
    private array $codes = [];

    private array $fields = [];

    public function __construct(
        public readonly string $sourceUrl,
    ) {
    }

    public function addCode(int|string $httpCode, string $description): void
    {
        $this->codes[$httpCode] = $description;
        ksort($this->codes, SORT_STRING);
    }

    public function getCodesAndDescriptions(): array
    {
        return $this->codes;
    }

    public function addField(int|string $httpCode, Field $field): void
    {
        if (!isset($this->fields[$httpCode])) {
            $this->fields[$httpCode] = [];
            ksort($this->fields[$httpCode], SORT_STRING);
        }
        if (isset($this->fields[$httpCode][$field->name])) {
            throw new RuntimeException("Duplicated response field: {$field->name}");
        }
        $this->fields[$httpCode][$field->name] = $field;
    }

    public function getAllFields(): array
    {
        $result = [];
        foreach ($this->fields as $statusCode => $fields) {
            $result[$statusCode] = array_values($fields);
        }

        return $result;
    }

    /**
     * @return \MLocati\Nexi\XPayWeb\Build\API\Field
     */
    public function getFields(int|string $httpCode): array
    {
        if (!isset($this->fields[$httpCode])) {
            return [];
        }

        return array_values($this->fields[$httpCode]);
    }
}
