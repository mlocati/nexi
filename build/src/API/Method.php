<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\API;

use MLocati\Nexi\Build\API;
use MLocati\Nexi\Build\API\Method\Definition;
use RuntimeException;

class Method
{
    public const HEADERFLAG_XAPIKEY = 0b1;

    public const HEADERFLAG_CORRELATIONID = 0b10;

    public const HEADERFLAG_IDEMPOTENCYKEY = 0b100;

    public readonly Definition $definition;

    public readonly Verb $verb;

    public string $description = '';

    public int $headerFlags = 0;

    /**
     * @var \MLocati\Nexi\Build\API\Field[] with keys
     */
    private array $pathFields = [];

    /**
     * @var \MLocati\Nexi\Build\API\Field[] with keys
     */
    private array $queryFields = [];

    /**
     * @var \MLocati\Nexi\Build\API\Field[] with keys
     */
    private array $bodyFields = [];

    /**
     * @var string[] with keys
     */
    private array $responseCodes = [];

    /**
     * @var \MLocati\Nexi\Build\API\Field[][] with keys
     */
    private array $responseFields = [];

    private ?Method\Type $queryType;

    private ?Method\Type $bodyType;

    /**
     * @var \MLocati\Nexi\Build\API\Method\Type[]|null[] with keys
     */
    private array $responseTypes;

    public function __construct(
        Verb $verb,
        public readonly string $path,
        public readonly string $see,
    ) {
        $this->definition = Definition::getByVerbAndPath($verb, $this->path) ?? throw RuntimeException("Unrecognized {$verb->value} method for path {$this->path}");
        $this->verb = $this->definition->overrideWrongVerb ?? $verb;
    }

    public function addPathField(Field $field): void
    {
        if (isset($this->pathFields[$field->name])) {
            throw new RuntimeException("Duplicated path field: {$field->name}");
        }
        $this->pathFields[$field->name] = $field;
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[]
     */
    public function getPathFields(): array
    {
        return array_values($this->pathFields);
    }

    public function addQueryField(Field $field): void
    {
        if (isset($this->queryFields[$field->name])) {
            throw new RuntimeException("Duplicated querystring field: {$field->name}");
        }
        $this->queryFields[$field->name] = $field;
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[]
     */
    public function getQueryFields(): array
    {
        return array_values($this->queryFields);
    }

    public function addBodyField(Field $field): void
    {
        if (isset($this->bodyFields[$field->name])) {
            throw new RuntimeException("Duplicated body field: {$field->name}");
        }
        $this->bodyFields[$field->name] = $field;
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[]
     */
    public function getBodyFields(): array
    {
        return array_values($this->bodyFields);
    }

    public function addResponseCode(int|string $httpResponseCode, string $description): void
    {
        $this->responseCodes[$httpResponseCode] = $description;
        ksort($this->responseCodes, SORT_STRING);
    }

    public function getResponseCodesAndDescriptions(): array
    {
        return $this->responseCodes;
    }

    public function addResponseField(int|string $httpResponseCode, Field $field): void
    {
        if (!isset($this->responseFields[$httpResponseCode])) {
            $this->responseFields[$httpResponseCode] = [];
            ksort($this->responseFields[$httpResponseCode], SORT_STRING);
        }
        if (isset($this->responseFields[$httpResponseCode][$field->name])) {
            throw new RuntimeException("Duplicated response field: {$field->name}");
        }
        $this->responseFields[$httpResponseCode][$field->name] = $field;
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[] with keys: http status codes
     */
    public function getAllResponseFields(): array
    {
        $result = [];
        foreach ($this->responseFields as $statusCode => $fields) {
            $result[$statusCode] = array_values($fields);
        }

        return $result;
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[]
     */
    public function getResponseFields(int|string $httpResponseCode): array
    {
        if (!isset($this->responseFields[$httpResponseCode])) {
            return [];
        }

        return array_values($this->responseFields[$httpResponseCode]);
    }

    public function resolveTypes(API $api): void
    {
        $this->queryType = $this->resolveType($api, $this->queryFields, 'Query', true, true);
        $this->bodyType = $this->resolveType($api, $this->bodyFields, 'Request', true, false);
        $responseTypes = [];
        foreach ($this->responseFields as $httpResponseCode => $fields) {
            $responseTypes[$httpResponseCode] = $this->resolveType($api, $fields, 'Response' . ((int) $httpResponseCode === 200 ? '' : $httpResponseCode), false, false);
        }
        $this->responseTypes = $responseTypes;
    }

    public function getQueryType(): ?Method\Type
    {
        return $this->queryType;
    }

    public function getBodyType(): ?Method\Type
    {
        return $this->bodyType;
    }

    /**
     * @return \MLocati\Nexi\Build\API\Method\Type[] array keys are the HTTP response codes
     */
    public function getResponseTypes(): array
    {
        return $this->responseTypes;
    }

    public function getSuccessType(): ?Method\Type
    {
        $result = null;
        foreach ($this->responseTypes as $httpResponseCode => $type) {
            $str = (string) $httpResponseCode;
            if ($str[0] !== '2') {
                continue;
            }
            if ($str !== '200') {
                throw new RuntimeException('Not implemented');
            }
            if ($result !== null) {
                throw new RuntimeException("Multiple '2xx' response types");
            }
            $result = $type;
        }

        return $result;
    }

    public function isReturnNullOn404(): bool
    {
        if (isset($this->responseTypes[404])) {
            return false;
        }
        $description = $this->responseCodes[404] ?? null;

        return $description !== null;
    }

    public function getErrorCases(): Method\ErrorCases
    {
        $items = [];
        foreach ($this->responseCodes as $httpResponseCode => $description) {
            $str = (string) $httpResponseCode;
            if ($str[0] === '2') {
                continue;
            }
            if ($str === '404' && $this->isReturnNullOn404()) {
                continue;
            }
            $type = $this->responseTypes[$httpResponseCode] ?? null;
            if ($type === null) {
                $withErrors = false;
            } else {
                if ($type->isArrayOf || $type->entity->name !== API::ENTITYNAME_ERRORS) {
                    throw new RuntimeException('Not implemented');
                }
                $withErrors = true;
            }
            $items[] = new Method\ErrorCases\Item(
                from: (int) str_replace('x', '0', $str),
                to: (int) str_replace('x', '9', $str),
                description: $description,
                withErrors: $withErrors,
            );
        }

        return new Method\ErrorCases($items);
    }

    /**
     * @param \MLocati\Nexi\Build\API\Field[] $fields
     */
    private function resolveType(API $api, array $fields, string $newEntityName, bool $addGetOrCreate, bool $isQuery): ?Method\Type
    {
        if ($fields === []) {
            return null;
        }
        foreach ($fields as $field) {
            if ($field->name !== '') {
                continue;
            }
            if (!$field->isArray || count($fields) !== 1) {
                throw new RuntimeException('Unexpected fields with unnamed field');
            }
            if ($field->type !== FieldType::Obj || $field->entity === null) {
                throw new RuntimeException('Not implemented');
            }

            return new Method\Type($field->entity, true);
        }
        $entity = $api->addEntity(
            preferredName: ucfirst($this->definition->name) . '\\' . $newEntityName,
            fields: $fields,
            addGetOrCreate: $addGetOrCreate,
            isQuery: $isQuery,
            see: $this->see,
        );

        return new Method\Type($entity, false);
    }
}
