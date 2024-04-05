<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\Parser\HtmlParser;

use DOMDocument;
use DOMElement;
use Generator;
use MLocati\Nexi\Build\API;
use MLocati\Nexi\Build\API\Entity;
use MLocati\Nexi\Build\API\Field;
use MLocati\Nexi\Build\API\FieldsData;
use MLocati\Nexi\Build\API\FieldType;
use MLocati\Nexi\Build\API\Method;
use MLocati\Nexi\Build\API\Verb;
use MLocati\Nexi\Build\Exception;
use MLocati\Nexi\Build\Parser\HtmlParser;
use RuntimeException;

class APIPage extends HtmlParser
{
    private const SKIP_PATHS = [
        '/en/api/introduzione',
        SpecificationsPage::PATH,
        APINotificationPage::PATH,
        ApiKeysPage::PATH,
        TestCardsPage::PATH,
    ];

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Build\Parser::shouldHandlePath()
     */
    public function shouldHandlePath(string $path): bool
    {
        if (in_array($path, self::SKIP_PATHS, true)) {
            return false;
        }

        return str_starts_with($path, '/en/api/');
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Build\Parser\HtmlParser::parseDoc()
     */
    public function parseDoc(string $see, string $path, DOMDocument $page, API $api): void
    {
        $main = $this->getElement($page, "descendant::div[@id='maincontent-wrapper']");
        $method = $this->createMethod($main, $see);
        $method->description = $this->extractDescription($main);
        $method->headerFlags = $this->extractHeaderFlags($main, $api, $method->definition->name, $see);
        foreach ($this->extractPathFields($main, $api, $method->definition->name, $see) as $field) {
            $method->addPathField($field);
        }
        foreach ($this->extractQueryFields($main, $api, $method->definition->name, $see) as $field) {
            $method->addQueryField($field);
        }
        foreach ($this->extractBodyFields($main, $api, $method->definition, $see) as $field) {
            $method->addBodyField($field);
        }
        foreach ($this->extractHttpResponseCodes($main, $api, $method->definition, $see) as [$httpResponseCode, $description, $fields]) {
            $method->addResponseCode($httpResponseCode, $description);
            foreach ($fields as $field) {
                $method->addResponseField($httpResponseCode, $field);
            }
        }
        $api->addMethod($method);
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[]
     */
    protected function extractFields(FieldsData $data, DOMElement $parent, array $cssClassNames, bool $addEntityOrCreate): array
    {
        $container = $this->getFieldsTable($parent, $cssClassNames);
        $mainTable = $this->getFieldsTable($container, ['params', 'sub-table-0']);
        if (preg_match('/^No param \\w+/', $this->getNormalizedText($mainTable))) {
            return [];
        }

        return $this->extractFieldsFromTable($data, $mainTable, $addEntityOrCreate);
    }

    protected function extractHttpResponseCodes(DOMElement $parent, API $api, Method\Definition $methodDefinition, string $see): Generator
    {
        $container = $this->getElement($parent, "descendant::div[@id='tab_response']");
        foreach ($this->findElements($container, 'descendant::div[@data-status-code]') as $section) {
            $statusCode = $section->getAttribute('data-status-code');
            if (preg_match('/^[1-9]\\d\\d$/', $statusCode)) {
                $statusCode = (int) $statusCode;
            } elseif (preg_match('/^[1-9]xx$/i', $statusCode)) {
                $statusCode = strtolower($statusCode);
            } else {
                throw new RuntimeException("Invalid HTTP status code: {$statusCode}");
            }
            $data = new FieldsData(
                api: $api,
                see: "{$see}#tab_response",
                methodName: $methodDefinition->name,
                when: Field\Required\When::Receiving,
                entityNamesByPath: $methodDefinition->getResponseBodyEntityNames($statusCode),
            );

            yield $this->parseResponseCode($data, $section, $statusCode);
        }
    }

    private function createMethod(DOMElement $main, string $see): Method
    {
        $header = $this->getElement($main, "descendant::h2[@class='page-title']");
        $verb = $this->getNormalizedText($this->getElement($header, "descendant::span[@class='method']"));
        $path = $this->getNormalizedText($this->getElement($header, "descendant::span[@class='url']"));

        return new Method(
            verb: Verb::from($verb),
            path: $path,
            see: $see
        );
    }

    private function extractDescription(DOMElement $main): string
    {
        $para = $this->findElement($main, "descendant::*[@class='summary-api']");
        if ($para === null) {
            return '';
        }

        return $this->getNormalizedText($para);
    }

    private function extractHeaderFlags(DOMElement $parent, API $api, string $methodName, string $see): int
    {
        $data = new FieldsData(
            api: $api,
            see: "{$see}#tab_header",
            methodName: $methodName,
            when: Field\Required\When::Sending,
        );
        $flags = 0;
        foreach ($this->extractFields($data, $parent, ['parameters', 'header'], false) as $field) {
            switch ($field->name) {
                case 'X-Api-Key':
                    $flags |= Method::HEADERFLAG_XAPIKEY;
                    break;
                case 'Correlation-Id':
                    $flags |= Method::HEADERFLAG_CORRELATIONID;
                    break;
                case 'Idempotency-Key':
                    $flags |= Method::HEADERFLAG_IDEMPOTENCYKEY;
                    break;
                default:
                    throw new RuntimeException("Unrecognized header: {$field->name}");
            }
        }

        return $flags;
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[]
     */
    private function extractPathFields(DOMElement $parent, API $api, string $methodName, string $see): array
    {
        $data = new FieldsData(
            api: $api,
            see: "{$see}#tab_url",
            methodName: $methodName,
            when: Field\Required\When::Sending,
        );

        return $this->extractFields($data, $parent, ['parameters', 'path'], false);
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[]
     */
    private function extractQueryFields(DOMElement $parent, API $api, string $methodName, string $see): array
    {
        $data = new FieldsData(
            api: $api,
            see: "{$see}#tab_url",
            methodName: $methodName,
            when: Field\Required\When::Sending,
        );

        return $this->extractFields($data, $parent, ['parameters', 'query'], true);
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[]
     */
    private function extractBodyFields(DOMElement $parent, API $api, Method\Definition $methodDefinition, string $see): array
    {
        $data = new FieldsData(
            api: $api,
            see: "{$see}#tab_body",
            methodName: $methodDefinition->name,
            when: Field\Required\When::Sending,
            entityNamesByPath: $methodDefinition->getRequestBodyEntityNames(),
        );

        return $this->extractFields($data, $parent, ['parameters', 'body'], true);
    }

    /**
     * @return \MLocati\Nexi\Build\API\Field[]
     */
    private function extractFieldsFromTable(FieldsData $data, DOMElement $table, bool $addEntityOrCreate): array
    {
        $result = [];
        $nextRowIsChildOf = null;
        foreach ($this->listBodyRows($table) as $row) {
            $rowIsChildOf = $nextRowIsChildOf;
            $nextRowIsChildOf = null;
            if ($rowIsChildOf !== null) {
                $subTable = null;
                if (str_contains((string) $row->getAttribute('class'), 'child')) {
                    if ($row->childElementCount === 1) {
                        $cell = $row->firstElementChild;
                        if ($cell->childElementCount === 1) {
                            $subTable = $cell->firstElementChild;
                        }
                    }
                }
                if ($subTable === null || strcasecmp($subTable->tagName, 'table') !== 0) {
                    switch ($rowIsChildOf->name) {
                        case 'additionalData': // https://developer.nexi.it/en/api/post-orders-2steps-init#tab_response
                        case 'actions': // https://developer.nexi.it/en/api/get-operations-operationId-actions
                            break;
                        default:
                            throw new RuntimeException("Missing object definition for field {$rowIsChildOf->entity->name}");
                    }
                } else {
                    $data->pushField($rowIsChildOf->name);
                    $rowIsChildOf->entity = $this->extractEntity($data, $subTable, $rowIsChildOf->preferredEntityName, $addEntityOrCreate);
                    $data->popField();
                    continue;
                }
            }
            $field = $this->extractFieldFromRow($data, $row);
            if ($field === null) {
                $html = $row->ownerDocument->saveHTML($row);
                throw new RuntimeException("Invalid field row:\n{$html}");
            }
            if ($field->type === FieldType::Obj) {
                $nextRowIsChildOf = $field;
            }
            $result[] = $field;
        }
        foreach ($result as $index => $field) {
            if ($field->name === '' && ($index > 0 || !$field->isArray)) {
                throw new RuntimeException('Empty field name detected');
            }
        }

        return $result;
    }

    private function extractFieldFromRow(FieldsData $data, DOMElement $row): ?Field
    {
        if ($row->childElementCount !== 5) {
            return null;
        }
        $cell = $row->firstElementChild;
        if ($this->getNormalizedText($cell) !== '') {
            return null;
        }
        $cell = $cell->nextElementSibling;
        $isRequired = preg_match('/\\brequired\\b/i', $cell->ownerDocument->saveHTML($cell)) > 0;
        $cell = $cell->nextElementSibling;
        $name = $this->getNormalizedText($cell);
        $cell = $cell->nextElementSibling;
        $description = $this->getNormalizedText($cell);
        $cell = $cell->nextElementSibling;
        $rawFormat = $this->getNormalizedText($cell);

        $required = new Field\Required(
            methodName: $data->methodName,
            when: $data->when,
            required: $isRequired,
        );

        return $this->buildField(
            required: $required,
            name: $name,
            description: $description,
            rawFormat: $rawFormat,
            overrideEntityName: $data->getEntityNameByPath($name),
        );
    }

    private function buildField(string $name, Field\Required $required, string $description, string $rawFormat, string $overrideEntityName = '')
    {
        $lines = explode("\n", $rawFormat);
        $rawType = array_shift($lines);
        $format = '';
        $minLength = null;
        $maxLength = null;
        $minimum = null;
        $maximum = null;
        $default = '';
        $examples = [];
        $m = null;
        foreach ($lines as $line) {
            if (preg_match('/^Format:\\s*(.+)$/i', $line, $m)) {
                $format = $m[1];
            } elseif (preg_match('/^Example:\\s*(.+)$/i', $line, $m)) {
                $examples[] = $m[1];
            } elseif (preg_match('/^Max\\.? ?length:\\s*(\\d+)$/i', $line, $m)) {
                $maxLength = (int) $m[1];
            } elseif (preg_match('/^Min\\.? ?length:\\s*(\\d+)$/i', $line, $m)) {
                $minLength = (int) $m[1];
            } elseif (preg_match('/^Default:\\s*(.+)$/i', $line, $m)) {
                $default = $m[1];
            } elseif (preg_match('/^Minimum:\\s*(\\d+)$/i', $line, $m)) {
                $minimum = (int) $m[1];
            } elseif (preg_match('/^Maximum:\\s*(\\d+)$/i', $line, $m)) {
                $maximum = (int) $m[1];
            } else {
                throw new RuntimeException("Unrecognized format line: {$line}");
            }
        }
        if (strtolower($rawType) === 'array') {
            $isArray = true;
            switch ($name) {
                case 'termsAndConditionsIds':
                    $rawType = 'string';
                    break;
                default:
                    $rawType = 'object';
                    break;
            }
        } else {
            $isArray = false;
        }
        switch (strtolower($rawType)) {
            case 'boolean':
                $field = Field::createBoolean(name: $name);
                break;
            case 'string':
                $field = Field::createString(name: $name, minLength: $minLength, maxLength: $maxLength);
                break;
            case 'number':
            case 'integer':
                $field = Field::createInteger(name: $name, minimum: $minimum, maximum: $maximum);
                break;
            case 'object':
                if ($overrideEntityName !== '') {
                    $preferredEntityName = $overrideEntityName;
                } else {
                    $preferredEntityName = ucfirst($name);
                    if ($isArray) {
                        switch ($preferredEntityName) {
                            case 'Errors':
                            case 'Warnings':
                            case 'Fields':
                            case 'Orders':
                            case 'Operations':
                            case 'PaymentLinks':
                            case 'Actions':
                            case 'Contracts':
                            case 'PaymentMethods':
                            case 'Installments':
                            case 'CustomFieldTranslations':
                                $preferredEntityName = substr($preferredEntityName, 0, -strlen('s'));
                                break;
                            case 'SummaryList':
                                $preferredEntityName = substr($preferredEntityName, 0, -strlen('List'));
                                break;
                            case 'TransactionSummary':
                            case 'TermsAndConditions':
                            case 'CancellationCondition':
                            case 'Reservation':
                            case 'CustomField':
                            case '':
                                break;
                            default:
                                throw new RuntimeException("Unknown singular form of entity list {$preferredEntityName}");
                        }
                    }
                }
                $field = Field::createObject(name: $name, preferredEntityName: $preferredEntityName, allowEmptyName: $isArray);
                break;
            default:
                throw new RuntimeException("Unrecognized type: {$rawType}");
        }
        $field->addRequired($required);
        $field->description = $description;
        $field->format = $format;
        $field->isArray = $isArray;
        $field->examples = $examples;
        $field->default = $default;

        return $field;
    }

    private function getFieldsTable(DOMElement $parent, array $classNames): DOMElement
    {
        $tables = [];
        foreach ($this->findElements($parent, 'descendant::table[@class]') as $table) {
            $class = strtolower(' ' . preg_replace('/\\s+/', ' ', (string) $table->getAttribute('class')) . ' ');
            foreach ($classNames as $className) {
                $className = strtolower($className);
                if (!str_contains($class, " {$className} ")) {
                    continue 2;
                }
            }
            $tables[] = $table;
        }
        $count = count($tables);
        switch ($count) {
            case 0:
                throw new Exception\FieldsTableNotFound('No field tables matching ' . implode('.', $classNames));
            case 1:
                return $tables[0];
        }
        throw new RuntimeException('Multiple tables matching ' . implode('.', $classNames) . " (expected: 1, found: {$count})");
    }

    private function extractEntity(FieldsData $data, DOMElement $table, string $preferredEntityName, bool $addGetOrCreate): Entity
    {
        $fields = $this->extractFieldsFromTable($data, $table, $addGetOrCreate);

        return $data->api->addEntity(
            preferredName: $preferredEntityName,
            fields: $fields,
            addGetOrCreate: $addGetOrCreate,
            see: $data->see
        );
    }

    private function parseResponseCode(FieldsData $data, DOMElement $container, int|string $statusCode): array
    {
        $header = $this->getElement($container, 'descendant::h6[not(@class)]');
        $description = $this->getNormalizedText($header);
        try {
            $fields = $this->extractFields($data, $container, ['parameters', "response-body-{$statusCode}"], false);
        } catch (Exception\FieldsTableNotFound $_) {
            $fields = [];
        }

        return [$statusCode, $description, $fields];
    }
}
