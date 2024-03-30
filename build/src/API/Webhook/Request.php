<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\API\Webhook;

use MLocati\Nexi\Build\API\Field;
use RuntimeException;

class Request
{
    private array $fields = [];

    public function __construct(
        public readonly string $sourceUrl,
    ) {
    }

    public function addField(Field $field): void
    {
        if (isset($this->fields[$field->name])) {
            throw new RuntimeException("Duplicated request field: {$field->name}");
        }
        $this->fields[$field->name] = $field;
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field
     */
    public function getFields(): array
    {
        return array_values($this->fields);
    }
}
