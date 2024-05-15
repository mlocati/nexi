<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\API;

use MLocati\Nexi\XPayWeb\Build\API;
use RuntimeException;

class FieldsData
{
    private array $fieldsPath = [];

    public function __construct(
        public readonly API $api,
        public readonly string $see,
        public readonly string $methodName,
        public readonly Field\Required\When $when,
        private readonly array $entityNamesByPath = [],
    ) {
    }

    public function pushField(string $name): void
    {
        $this->fieldsPath[] = $name;
    }

    public function popField(): void
    {
        if ($this->fieldsPath === []) {
            throw new RuntimeException('Empty fields path');
        }
        array_pop($this->fieldsPath);
    }

    public function getEntityNameByPath(string $fieldName): string
    {
        $key = implode('.', array_merge($this->fieldsPath, [$fieldName]));

        return $this->entityNamesByPath[$key] ?? '';
    }
}
