<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build;

use MLocati\Nexi\Build\API\Entity;
use MLocati\Nexi\Build\API\Field;
use MLocati\Nexi\Build\API\FieldType;
use MLocati\Nexi\Build\API\Method;
use RuntimeException;

class Writer
{
    private readonly string $templatesDirectory;
    private readonly string $outputDirectory;

    public function __construct(
        string $templatesDirectory,
        string $outputDirectory,
    ) {
        $dir = is_dir($templatesDirectory) ? realpath($templatesDirectory) : false;
        if ($dir === false) {
            throw new RuntimeException("Invalid templates directory: {$templatesDirectory}");
        }
        $this->templatesDirectory = str_replace(DIRECTORY_SEPARATOR, '/', $dir);
        if (!is_dir($outputDirectory) && !mkdir($outputDirectory, 0777, true)) {
            throw new RuntimeException("Failed to create directory {$outputDirectory}");
        }
        $this->outputDirectory = str_replace(DIRECTORY_SEPARATOR, '/', realpath($outputDirectory));
    }

    public function write(API $api): void
    {
        $this->deleteGeneratedFiles();
        $this->writeConfiguration($api);
        $this->writeLanguages($api);
        $this->writeErrorCodes($api);
        $this->writeCurrencies($api);
        $this->writePaymentServices($api);
        $this->writeResponseCodes($api);
        $this->writeTestCards($api);
        $this->writeEntities($api);
        $this->writeWebHooks($api);
        $this->writeClient($api);
    }

    private function writeConfiguration(API $api): void
    {
        $baseUrlTest = $api->getBaseUrlTest();
        if ($baseUrlTest === '') {
            throw new RuntimeException('Missing base URL for test');
        }
        $baseUrlTestSource = $api->getBaseUrlTestSource();
        if ($baseUrlTestSource === '') {
            throw new RuntimeException('Missing source of base URL for test');
        }
        $baseUrlProduction = $api->getBaseUrlProduction();
        if ($baseUrlProduction === '') {
            throw new RuntimeException('Missing base URL for production');
        }
        $baseUrlProductionSource = $api->getBaseUrlProductionSource();
        if ($baseUrlProductionSource === '') {
            throw new RuntimeException('Missing source of base URL for production');
        }
        $apiKeyTest = $api->getApiKeyTest();
        if ($apiKeyTest === '') {
            throw new RuntimeException('Missing API key for test');
        }
        $apiKeyTestSource = $api->getApiKeyTestSource();
        if ($apiKeyTestSource === '') {
            throw new RuntimeException('Missing source of API key for test');
        }
        $template = Writer\Template::fromFile("{$this->templatesDirectory}/Configuration.php");
        $template->fillPlaceholder('TEST_URL_PHPDOC', [
            '/**',
            ' * This is the default URL to be used for tests.',
            ' *',
            " * @see {$baseUrlTestSource}",
            ' *',
            ' * @var string',
            ' */',
        ]);
        $template->fillPlaceholder('TEST_URL', [$baseUrlTest], false);
        $template->fillPlaceholder('PRODUCTION_URL_PHPDOC', [
            '/**',
            ' * This is the default URL to be used in production.',
            ' *',
            " * @see {$baseUrlProductionSource}",
            ' *',
            ' * @var string',
            ' */',
        ]);
        $template->fillPlaceholder('PRODUCTION_URL', [$baseUrlProduction], false);
        $template->fillPlaceholder('TEST_APIKEY_PHPDOC', [
            '/**',
            ' * This is an API key you can use for tests.',
            ' *',
            " * @see {$apiKeyTestSource}",
            ' *',
            ' * @var string',
            ' */',
        ]);
        $template->fillPlaceholder('TEST_APIKEY', [$apiKeyTest], false);
        $template->save("{$this->outputDirectory}/Configuration.php");
    }

    private function writeLanguages(API $api): void
    {
        $value = $api->getLanguages();
        if ($value === null || $value === []) {
            throw new RuntimeException('Missing or empty languages');
        }
        $source = $api->getLanguagesSource();
        if ($source === '') {
            throw new RuntimeException('Missing languages source');
        }
        $template = Writer\Template::fromFile("{$this->templatesDirectory}/Dictionary/Language.php");
        $template->fillPlaceholder('CLASS_PHPDOC', [
            '/**',
            ' * List of ISO 639-2 codes of the languages supported by Nexi.',
            ' *',
            " * @see {$source}",
            ' */',
        ]);
        $lines = [];
        foreach ($value as $key => $name) {
            if ($lines !== []) {
                $lines[] = '';
            }
            $uKey = strtoupper($key);
            $lines[] = '/**';
            $lines[] = " * {$name}";
            $lines[] = ' *';
            $lines[] = ' * @var string';
            $lines[] = ' */';
            $lines[] = "const ID_{$uKey} = '{$key}';";
        }
        $template->fillPlaceholder('IDS', $lines);
        $template->save("{$this->outputDirectory}/Dictionary/Language.php");
    }

    private function writeErrorCodes(API $api): void
    {
        $value = $api->getErrorCodes();
        if ($value === null || $value === []) {
            throw new RuntimeException('Missing or empty error codes');
        }
        $source = $api->getErrorCodesSource();
        if ($source === '') {
            throw new RuntimeException('Missing error codes source');
        }
        $template = Writer\Template::fromFile("{$this->templatesDirectory}/Dictionary/ErrorCode.php");
        $template->fillPlaceholder('CLASS_PHPDOC', [
            '/**',
            ' * List of error codes.',
            ' *',
            " * @see {$source}",
            ' */',
        ]);
        $lines = [];
        foreach ($value as $key => $name) {
            if ($lines !== []) {
                $lines[] = '';
            }
            $uKey = strtoupper($key);
            $lines[] = '/**';
            $lines[] = " * {$name}";
            $lines[] = ' *';
            $lines[] = ' * @var string';
            $lines[] = ' */';
            $lines[] = "const ID_{$uKey} = '{$key}';";
        }
        $template->fillPlaceholder('IDS', $lines);
        $template->save("{$this->outputDirectory}/Dictionary/ErrorCode.php");
    }

    private function writeCurrencies(API $api): void
    {
        $dictionary = $api->getCurrencies();
        if ($dictionary === null || $dictionary === []) {
            throw new RuntimeException('Missing or empty currency dictionary');
        }
        $decimals = $api->getCurrencyDecimals();
        if ($decimals === null || $decimals === []) {
            throw new RuntimeException('Missing or empty currency decimals');
        }
        $missing = [];
        foreach (array_diff(array_keys($dictionary), array_keys($decimals)) as $currency) {
            switch ($currency) {
                default:
                    $missing[] = $currency;
                    break;
            }
        }
        if ($missing !== []) {
            throw new RuntimeException("The following currencies are defined in the dictionary but we don't know their relevant decimal places:\n- " . implode("\n- ", $missing));
        }
        ksort($decimals);
        $missing = [];
        foreach (array_diff(array_keys($decimals), array_keys($dictionary)) as $currency) {
            switch ($currency) {
                case 'BAM':
                    $dictionary[$currency] = 'Bosnia and Herzegovina convertible mark';
                    break;
                case 'GIP':
                    $dictionary[$currency] = 'Gibraltar pound';
                    break;
                case 'ISK':
                    $dictionary[$currency] = 'Icelandic krona';
                    break;
                case 'MKD':
                    $dictionary[$currency] = 'Macedonian denar';
                    break;
                default:
                    $missing[] = $currency;
                    break;
            }
        }
        if ($missing !== []) {
            throw new RuntimeException("The following currencies are defined in the decimal places but not in the dictionary:\n- " . implode("\n- ", $missing));
        }
        ksort($dictionary);
        $dictionarySource = $api->getCurrenciesSource();
        if ($dictionarySource === '') {
            throw new RuntimeException('Missing currency dictionary source');
        }
        $decimalsSource = $api->getCurrencyDecimalsSource();
        if ($dictionarySource === '') {
            throw new RuntimeException('Missing currency decimals source');
        }
        $template = Writer\Template::fromFile("{$this->templatesDirectory}/Dictionary/Currency.php");
        $template->fillPlaceholder('CLASS_PHPDOC', [
            '/**',
            ' * List of currencies supported by Nexi.',
            ' *',
            " * @see {$dictionarySource}",
            ' */',
        ]);
        $template->fillPlaceholder('MOVE_DECIMALS_DOC', [
            '/**',
            " * @see {$decimalsSource}",
            ' */',
        ]);
        $lines = [];
        foreach ($dictionary as $key => $name) {
            if ($lines !== []) {
                $lines[] = '';
            }
            $uKey = strtoupper($key);
            $lines[] = '/**';
            $lines[] = " * {$name}";
            $lines[] = ' *';
            $lines[] = ' * @var string';
            $lines[] = ' */';
            $lines[] = "const ID_{$uKey} = '{$key}';";
        }
        $template->fillPlaceholder('IDS', $lines);
        $lines = [];
        foreach ($decimals as $key => $num) {
            $uKey = strtoupper($key);
            $lines[] = "self::ID_{$uKey} => {$num},";
        }
        $template->fillPlaceholder('MOVE_DECIMALS', $lines);
        $template->save("{$this->outputDirectory}/Dictionary/Currency.php");
    }

    private function writePaymentServices(API $api): void
    {
        $value = $api->getPaymentServices();
        if ($value === null || $value === []) {
            throw new RuntimeException('Missing or empty payment services');
        }
        $source = $api->getLanguagesSource();
        if ($source === '') {
            throw new RuntimeException('Missing payment services source');
        }
        $template = Writer\Template::fromFile("{$this->templatesDirectory}/Dictionary/PaymentService.php");
        $template->fillPlaceholder('CLASS_PHPDOC', [
            '/**',
            ' * List of payment services supported by Nexi.',
            ' *',
            " * @see {$source}",
            ' */',
        ]);
        $lines = [];
        foreach ($value as $key => $name) {
            if ($lines !== []) {
                $lines[] = '';
            }
            $uKey = strtoupper($key);
            $lines[] = '/**';
            $lines[] = " * {$name}";
            $lines[] = ' *';
            $lines[] = ' * @var string';
            $lines[] = ' */';
            $lines[] = "const ID_{$uKey} = '{$key}';";
        }
        $template->fillPlaceholder('IDS', $lines);
        $template->save("{$this->outputDirectory}/Dictionary/PaymentService.php");
    }

    private function writeResponseCodes(API $api): void
    {
        $value = $api->getISO8583ResponseCodes();
        if ($value === null || $value === []) {
            throw new RuntimeException('Missing or empty ISO 8583 response codes');
        }
        $source = $api->getISO8583ResponseCodesSource();
        if ($source === '') {
            throw new RuntimeException('Missing ISO 8583 response codes source');
        }
        $template = Writer\Template::fromFile("{$this->templatesDirectory}/Dictionary/ResponseCode.php");
        $template->fillPlaceholder('CLASS_PHPDOC', [
            '/**',
            ' * List of ISO 8583 response codes.',
            ' *',
            " * @see {$source}",
            ' */',
        ]);
        $lines = [];
        foreach ($value as $key => $name) {
            if ($lines !== []) {
                $lines[] = '';
            }
            $key = str_pad((string) $key, 3, '0', STR_PAD_LEFT);
            $uKey = strtoupper($key);
            $lines[] = '/**';
            $lines[] = " * {$name}";
            $lines[] = ' *';
            $lines[] = ' * @var string';
            $lines[] = ' */';
            $lines[] = "const ID_{$uKey} = '{$key}';";
        }
        $template->fillPlaceholder('IDS', $lines);
        $template->save("{$this->outputDirectory}/Dictionary/ResponseCode.php");
    }

    private function writeTestCards(API $api): void
    {
        $value = $api->getTestCards();
        if ($value === null || $value === []) {
            throw new RuntimeException('Missing or empty test cards');
        }
        $source = $api->getTestCardsSource();
        if ($source === '') {
            throw new RuntimeException('Missing test casrds source');
        }
        $template = Writer\Template::fromFile("{$this->templatesDirectory}/Dictionary/TestCard.php");
        $template->fillPlaceholder('CLASS_PHPDOC', [
            '/**',
            ' * List of cards that can be used for tests.',
            ' *',
            " * @see {$source}",
            ' */',
        ]);
        $lines = array_map(
            static fn (array $card): string => implode('', [
                'new Card(',
                json_encode($card['positiveOutcome']),
                ", '{$card['circuit']}'",
                ", '{$card['formattedCardNumber']}'",
                ", {$card['expiryMonth']}",
                ", {$card['expiryYear']}",
                ", '{$card['cvv']}'",
                '),',
            ]),
            $value
        );
        $template->fillPlaceholder('CARDS', $lines);
        $template->save("{$this->outputDirectory}/Dictionary/TestCard.php");
    }

    private function deleteGeneratedFiles(): void
    {
        foreach ([
            'Dictionary/Currency.php',
            'Dictionary/ErrorCode.php',
            'Dictionary/Language.php',
            'Dictionary/PaymentService.php',
            'Dictionary/ResponseCode.php',
            'Dictionary/TestCard.php',
            'Entity/',
            'Client.php',
            'Configuration.php',
        ] as $name) {
            $isDir = str_ends_with($name, '/');
            $fullPath = "{$this->outputDirectory}/{$name}";
            if ($isDir) {
                $fullPath = rtrim($fullPath, '/');
                if (is_dir($fullPath)) {
                    if (DIRECTORY_SEPARATOR === '\\') {
                        $cmd = 'RMDIR /S /Q ' . escapeshellarg(str_replace('/', DIRECTORY_SEPARATOR, $fullPath));
                    } else {
                        $cmd = 'rm -rf ' . escapeshellarg($fullPath);
                    }
                    $output = [];
                    $rc = -1;
                    exec("{$cmd} 2>&1", $output, $rc);
                    if ($rc !== 0) {
                        throw new RuntimeException("Failed to delete directory {$fullPath}.\n" . implode("\n", $output));
                    }
                }
            } else {
                if (is_file($fullPath)) {
                    if (!unlink($fullPath)) {
                        throw new RuntimeException("Failed to delete file {$fullPath}.\n" . implode("\n", $output));
                    }
                }
            }
        }
    }

    private function writeEntities(API $api): void
    {
        $value = $api->getEntities();
        if ($value === null || $value === []) {
            throw new RuntimeException('Missing or empty entities');
        }
        foreach ($value as $entity) {
            $this->writeEntity($entity);
        }
    }

    private function writeEntity(Entity $entity): void
    {
        $template = Writer\Template::fromFile("{$this->templatesDirectory}/EntityTemplate.php");
        $index = strrpos($entity->name, '\\');
        if ($index === false) {
            $namespace = '';
            $className = $entity->name;
        } else {
            $namespace = '\\' . substr($entity->name, 0, $index);
            $className = substr($entity->name, $index + 1);
        }
        $lines = [];
        $see = $entity->getSee();
        if ($see !== []) {
            $lines[] = '/**';
            foreach ($see as $item) {
                $lines[] = " * @see {$item}";
            }
            $lines[] = ' */';
        }
        $template->fillPlaceholder('SEE', $lines);

        $template->fillPlaceholder('NAMESPACE', $namespace === '' ? [] : [$namespace], false);
        $template->fillPlaceholder('CLASSNAME', [$className], false);
        $template->fillPlaceholder('IMPLEMENTS', $entity->isQuery ? [' implements \\MLocati\\Nexi\\Service\\QueryEntityInterface'] : [''], true);
        $template->fillPlaceholder('FIELDS', $this->buildEntityFieldsLines($entity));
        $filename = "{$this->outputDirectory}/Entity" . str_replace('\\', '/', $namespace) . '/' . $className . '.php';
        $template->save($filename);
    }

    private function buildEntityFieldsLines(Entity $entity): array
    {
        $result = [];
        if ($entity->isQuery) {
            $result[] = 'use \\MLocati\\Nexi\\Service\\QueryEntityTrait;';
        }
        foreach ($entity->getFields() as $field) {
            if ($result !== []) {
                $result[] = '';
            }
            $result = array_merge($result, $this->buildEntityFieldLines($entity, $field));
        }

        return $result;
    }

    private function buildEntityFieldLines(Entity $owner, Field $field): array
    {
        if ($field->name === '') {
            throw new RuntimeException('Not yet implemented');
        }
        $uc1FieldName = ucfirst($field->name);
        if ($field->type === FieldType::Obj && $field->entity !== null) {
            $entityFullName = '\\MLocati\\Nexi\\Entity\\' . $field->entity->name;
            if (str_contains($owner->name, '\\')) {
                $entityRelativeName = '\\MLocati\\Nexi\\Entity\\' . $field->entity->name;
            } else {
                $entityRelativeName = $field->entity->name;
            }
        }
        $phpDocType = '';
        $phpType = '';
        if ($field->isArray) {
            $phpType .= 'array';
            switch ($field->type) {
                case FieldType::Obj:
                    if ($field->entity !== null) {
                        $phpDocType .= $entityFullName . '[]';
                    } else {
                        $phpDocType .= 'object[]|array[]';
                    }
                    break;
                default:
                    $phpDocType .= $field->type->value . '[]';
                    break;
            }
        } else {
            switch ($field->type) {
                case FieldType::Obj:
                    if ($field->entity === null) {
                        $phpDocType = 'object|array';
                    } else {
                        $phpType = $entityRelativeName;
                    }
                    break;
                default:
                    $phpType = $field->type->value;
                    break;
            }
        }
        $allCommentChunks = [];
        if ($field->description !== '') {
            $allCommentChunks['description'] = explode("\n", $field->description);
        }
        if ($phpDocType !== '') {
            $allCommentChunks['setterParamType'] = ["@param {$phpDocType}" . ($field->isAlwaysRequired() ? '' : '|null') . ' $value'];
        }

        if ($field->format !== '') {
            $allCommentChunks['format'] = "Format: {$field->format}";
        }
        if ($field->default !== '') {
            $allCommentChunks['default'] = ["@default {$field->default}"];
        }
        $restrictions = [];
        $restrictions = array_merge($restrictions, $field->getRequiredPHPDocLines());
        if ($field->minLength !== null) {
            $restrictions[] = "Minimum length: {$field->minLength}";
        }
        if ($field->maxLength !== null) {
            $restrictions[] = "Maximum length: {$field->maxLength}";
        }
        if ($field->minimum !== null) {
            $restrictions[] = "Minimum: {$field->minimum}";
        }
        if ($field->maximum !== null) {
            $restrictions[] = "Maximum: {$field->maximum}";
        }
        if ($restrictions !== []) {
            $allCommentChunks['restrictions'] = $restrictions;
        }
        $exceptions = [
            '@throws \\MLocati\\Nexi\\Exception\\WrongFieldType',
        ];
        $allCommentChunks['getterExceptions'] = $exceptions;
        if ($phpDocType !== '') {
            $allCommentChunks['getterReturnType'] = ["@return {$phpDocType}|null"];
        }
        $allCommentChunks['setterReturnType'] = ['@return $this'];

        $allCommentChunks['examples'] = [];
        foreach ($field->examples as $example) {
            if ($example !== '' && ($field->type !== FieldType::Boolean || !in_array($example, ['0', '1', true]))) {
                $allCommentChunks['examples'][] = "@example {$example}";
            }
        }
        if ($allCommentChunks['examples'] === []) {
            unset($allCommentChunks['examples']);
        }

        $result = [];
        $commentChunks = array_filter($allCommentChunks, static fn (string $key): bool => !str_starts_with($key, 'setter'), ARRAY_FILTER_USE_KEY);
        if ($commentChunks !== []) {
            $result[] = '/**';
            $commentChunks = array_values($commentChunks);
            foreach ($commentChunks as $index => $lines) {
                if ($index > 0) {
                    $result[] = ' *';
                }
                foreach ($lines as $line) {
                    $result[] = rtrim(" * {$line}");
                }
            }
            $result[] = ' */';
        }
        $signature = "public function get{$uc1FieldName}()";
        if ($phpType !== '') {
            $signature .= ": ?{$phpType}";
        }
        $result[] = $signature;
        $result[] = '{';
        $arraySuffix = $field->isArray ? 'Array' : '';
        switch ($field->type) {
            case FieldType::Boolean:
                if (array_intersect($field->examples, ['0', '1']) !== []) {
                    $allow01 = ', true';
                } else {
                    $allow01 = '';
                }
                $body = <<<EOT
                return \$this->_getBool{$arraySuffix}('{$field->name}'{$allow01});
                EOT;
                break;
            case FieldType::Integer:
                $body = <<<EOT
                return \$this->_getInt{$arraySuffix}('{$field->name}');
                EOT;
                break;
            case FieldType::Str:
                $body = <<<EOT
                return \$this->_getString{$arraySuffix}('{$field->name}');
                EOT;
                break;
            case FieldType::Obj:
                if ($field->entity === null) {
                    $body = <<<EOT
                    return \$this->_getCustomObject{$arraySuffix}('{$field->name}');
                    EOT;
                } else {
                    $body = <<<EOT
                    return \$this->_getEntity{$arraySuffix}('{$field->name}', {$entityRelativeName}::class);
                    EOT;
                }
                break;
            default:
                throw new RuntimeException('Unrecognized field type: ' . $field->type->value);
        }
        foreach (explode("\n", trim($body)) as $line) {
            $line = trim($line);
            if ($line === '') {
                $result[] = '';
            } else {
                $result[] = "    {$line}";
            }
        }
        $result[] = '}';
        if ($owner->addGetOrCreate && !$field->isArray && $field->type === FieldType::Obj && $field->entity !== null) {
            $result[] = '';
            $result[] = '/**';
            $result[] = " * @see \\MLocati\\Nexi\\Entity\\{$owner->name}::get{$uc1FieldName}()";
            $result[] = ' */';
            $result[] = "public function getOrCreate{$uc1FieldName}(): {$entityRelativeName}";
            $result[] = '{';
            $result[] = "    \$result = \$this->get{$uc1FieldName}();";
            $result[] = '    if ($result === null) {';
            $result[] = "        \$this->set{$uc1FieldName}(\$result = new {$entityRelativeName}());";
            $result[] = '    }';
            $result[] = '';
            $result[] = '    return $result;';
            $result[] = '}';
        }
        $result[] = '';
        $commentChunks = array_filter($allCommentChunks, static fn (string $key): bool => !str_starts_with($key, 'getter'), ARRAY_FILTER_USE_KEY);
        if ($commentChunks !== []) {
            $result[] = '/**';
            $commentChunks = array_values($commentChunks);
            foreach ($commentChunks as $index => $lines) {
                if ($index > 0) {
                    $result[] = ' *';
                }
                foreach ($lines as $line) {
                    $result[] = rtrim(" * {$line}");
                }
            }
            $result[] = ' */';
        }
        $signature = 'public function set' . ucfirst($field->name) . '(';
        if ($phpType !== '') {
            $signature .= ($field->isAlwaysRequired() ? '' : '?') . $phpType . ' ';
        }
        $signature .= '$value): self';
        $result[] = $signature;
        $result[] = '{';
        if ($field->isArray) {
            switch ($field->type) {
                case FieldType::Boolean:
                    $set = "\$this->_setBoolArray('{$field->name}', \$value)";
                    break;
                case FieldType::Integer:
                    $set = "\$this->_setIntArray('{$field->name}', \$value)";
                    break;
                case FieldType::Str:
                    $set = "\$this->_setStringArray('{$field->name}', \$value)";
                    break;
                case FieldType::Obj:
                    if ($field->entity === null) {
                        $set = "\$this->_setCustomObjectArray('{$field->name}', \$value)";
                    } else {
                        $set = "\$this->_setEntityArray('{$field->name}', {$entityRelativeName}::class, \$value)";
                    }
                    break;
                default:
                    throw new RuntimeException('Unrecognized field type: ' . $field->type->value);
            }
        } else {
            if ($field->type === FieldType::Obj && $field->entity === null) {
                $set = "\$this->_setCustomObject('{$field->name}', \$value)";
            } else {
                $set = "\$this->_set('{$field->name}', \$value)";
            }
        }
        $result[] = '    return ' . ($field->isAlwaysRequired() ? '' : "\$value === null ? \$this->_unset('{$field->name}') : ") . $set . ';';
        $result[] = '}';

        return $result;
    }

    private function writeWebHooks(API $api): void
    {
        $value = $api->getWebhookRequest();
        if ($value === null) {
            throw new RuntimeException('Missing webhook request');
        }
        $entity = new Entity('Webhook\\Request', addGetOrCreate: false, see: $value->sourceUrl);
        foreach ($value->getFields() as $field) {
            $entity->addField($field);
        }
        $this->writeEntity($entity);
        $value = $api->getWebhookResponse();
        if ($value === null) {
            throw new RuntimeException('Missing webhook response');
        }
        foreach (array_keys($value->getCodesAndDescriptions()) as $httpCode) {
            $fields = $value->getFields($httpCode);
            if ($fields === []) {
                continue;
            }
            $entity = new Entity('Webhook\\Response' . $httpCode, addGetOrCreate: false, see: $value->sourceUrl);
            foreach ($value->getFields() as $field) {
                $entity->addField($field);
            }
            $this->writeEntity($entity);
        }
    }

    private function writeClient(API $api): void
    {
        $template = Writer\Template::fromFile("{$this->templatesDirectory}/Client.php");
        $template->fillPlaceholder('HEADERFLAG_XAPIKEY', [(string) Method::HEADERFLAG_XAPIKEY], false);
        $template->fillPlaceholder('HEADERFLAG_CORRELATIONID', [(string) Method::HEADERFLAG_CORRELATIONID], false);
        $template->fillPlaceholder('HEADERFLAG_IDEMPOTENCYKEY', [(string) Method::HEADERFLAG_IDEMPOTENCYKEY], false);
        $template->fillPlaceholder('METHODS', $this->buildClientMethodsLines($api));
        $template->save("{$this->outputDirectory}/Client.php");
    }

    private function buildClientMethodsLines(API $api): array
    {
        $result = [];
        foreach ($api->getMethods() as $method) {
            if ($result !== []) {
                $result[] = '';
            }
            $result = array_merge($result, $this->buildClientMethodLines($method));
        }

        return $result;
    }

    private function buildClientMethodLines(Method $method): array
    {
        $queryType = $method->getQueryType();
        $bodyType = $method->getBodyType();
        $successType = $method->getSuccessType();
        $errorCases = $method->getErrorCases();
        $hasIdempotencyKey = ($method->headerFlags & Method::HEADERFLAG_IDEMPOTENCYKEY) === Method::HEADERFLAG_IDEMPOTENCYKEY;
        $phpDocParams = [];
        $phpParams = [];
        foreach ($method->getPathFields() as $field) {
            /** @var \MLocati\Nexi\Build\API\Field $field */
            if ($field->isArray) {
                throw new RuntimeException('Not implemented');
            }
            switch ($field->type) {
                case FieldType::Integer:
                case FieldType::Str:
                    if ($field->description !== '') {
                        $phpDocParams[] = "@param {$field->type->value} \${$field->name} " . str_replace("\n", ' ', $field->description);
                    }
                    $phpParams[] = "{$field->type->value} \${$field->name}";
                    break;
                default:
                    throw new RuntimeException('Not implemented');
            }
        }
        if ($bodyType !== null) {
            if ($bodyType->isArrayOf) {
                $phpDocParams[] = "@param Entity\\{$bodyType->entity->name}[] \$requestBody";
                $phpParams[] = 'array $requestBody';
            } else {
                $phpParams[] = "Entity\\{$bodyType->entity->name} \$requestBody";
            }
        }
        if ($queryType !== null) {
            $queryTypeRequired = $queryType->entity->isSomeFieldAlwaysRequired();
            if ($queryType->isArrayOf) {
                throw new RuntimeException('Not implemented');
            }
            $phpParams[] = ($queryTypeRequired ? '' : '?') . 'Entity\\' . $queryType->entity->name . ' $query' . ($queryTypeRequired ? '' : ' = null');
        }
        if ($hasIdempotencyKey) {
            $phpDocParams[] = '@param string $idempotencyKey an identifier of the request (to be used on subsequent retries); if empty, it will be set as output';
            $phpParams[] = 'string &$idempotencyKey = \'\'';
        }
        $commentChunks = [];
        if ($method->description !== []) {
            $commentChunks[] = explode("\n", $method->description);
        }
        if ($phpDocParams !== []) {
            $commentChunks[] = $phpDocParams;
        }
        if ($method->see !== '') {
            $commentChunks[] = ["@see {$method->see}"];
        }
        $throws = [
            '@throws \\MLocati\\Nexi\\Exception\\HttpRequestFailed if the HTTP request could not be made',
        ];
        if ($successType !== null || $errorCases->isSomeItemUsingJson) {
            $throws[] = "@throws \\MLocati\\Nexi\\Exception\\InvalidJson if we couldn't decode the response body as JSON";
        }
        foreach ($errorCases->items as $item) {
            $throws[] = $item->getThrowsPhpDocLine();
        }
        $throws[] = '@throws \\MLocati\\Nexi\\Exception\\ErrorResponse';
        $commentChunks[] = array_values(array_unique($throws));

        $signature = 'public function ' . $method->definition->name . '(';
        $signature .= implode(', ', $phpParams);
        $signature .= '): ';
        if ($successType === null) {
            if ($method->isReturnNullOn404()) {
                $signature .= 'bool';
                $commentChunks[] = ['@return bool returns FALSE if not found'];
            } else {
                $signature .= 'void';
            }
        } else {
            if ($successType->isArrayOf) {
                $signature .= 'array';
            } else {
                if ($method->isReturnNullOn404()) {
                    $signature .= '?';
                    $commentChunks[] = ['@return \\MLocati\\Nexi\\Entity\\' . $successType->entity->name . '|null returns NULL if not found'];
                }
                $signature .= 'Entity\\' . $successType->entity->name;
            }
        }

        $result = [];
        $first = true;
        foreach ($commentChunks as $chunk) {
            if ($first) {
                $first = false;
                $result[] = '/**';
            } else {
                $result[] = ' *';
            }
            foreach ($chunk as $line) {
                $result[] = ' *' . ($line === '' ? '' : " {$line}");
            }
        }
        if (!$first) {
            $result[] = ' */';
        }
        $result[] = $signature;
        $result[] = '{';
        $buildUrlParams = ["'{$method->path}'"];
        if ($queryType !== null || $method->getPathFields() !== []) {
            $buildUrlParams[] = '[' . implode(', ', array_map(
                static fn (Field $field): string => "'{$field->name}' => \${$field->name}",
                $method->getPathFields()
            )) . ']';
            if ($queryType !== null) {
                $buildUrlParams[] = '$query';
            }
        }
        $result[] = '    $url = $this->buildUrl(' . implode(', ', $buildUrlParams) . ');';
        $invoke = "\$response = \$this->invoke('{$method->verb->value}', \$url, {$method->headerFlags}";
        if ($bodyType !== null || $hasIdempotencyKey) {
            $invoke .= ', ' . ($bodyType === null ? 'null' : '$requestBody');
            if ($hasIdempotencyKey) {
                $invoke .= ', $idempotencyKey';
            }
        }
        $invoke .= ');';
        $result[] = "    {$invoke}";
        if ($successType === null) {
            $result[] = '    if ($response->getStatusCode() === 200) {';
            if ($method->isReturnNullOn404()) {
                $result[] = '        return true;';
            } else {
                $result[] = '        return;';
            }
            $result[] = '    }';
            if ($method->isReturnNullOn404()) {
                $result[] = '    if ($response->getStatusCode() === 404) {';
                $result[] = '        return false;';
                $result[] = '    }';
            }
        } else {
            $result[] = '    if ($response->getStatusCode() === 200) {';
            if ($successType->isArrayOf) {
                $result[] = '        $data = $this->decodeJsonToArray($response->getBody());';
                $result[] = '';
                $result[] = '        return array_map(static function (array $item) { return new Entity\\' . $successType->entity->name . '($item); }, $data);';
            } else {
                $result[] = '        $data = $this->decodeJsonToObject($response->getBody());';
                $result[] = '';
                $result[] = '        return new Entity\\' . $successType->entity->name . '($data);';
            }
            $result[] = '    }';
            if ($method->isReturnNullOn404()) {
                $result[] = '    if ($response->getStatusCode() === 404) {';
                if ($successType->isArrayOf) {
                    $result[] = '        return [];';
                } else {
                    $result[] = '        return null;';
                }
                $result[] = '    }';
            }
        }
        $result[] = '    $this->throwErrorResponse($response, ' . $errorCases->toPHP('        ') . ');';
        $result[] = '}';

        return $result;
    }
}
