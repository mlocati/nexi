<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build;

use MLocati\Nexi\Build\API\Entity;
use MLocati\Nexi\Build\API\Field;
use MLocati\Nexi\Build\API\Method;
use MLocati\Nexi\Build\API\Webhook;
use RuntimeException;

class API
{
    public const ENTITYNAME_ERRORS = 'Errors';

    /**
     * @var \MLocati\Nexi\Build\API\Method[] with keys
     */
    private array $methods = [];

    /**
     * @var \MLocati\Nexi\Build\API\Entity[]
     */
    private array $entities = [];

    private ?Webhook\Request $webhookRequest = null;

    private ?Webhook\Response $webhookResponse = null;

    private string $baseUrlTestSource = '';
    private string $baseUrlTest = '';

    private string $baseUrlProductionSource = '';
    private string $baseUrlProduction = '';

    private string $languagesSource = '';
    private ?array $languages = null;

    private string $errorCodesSource = '';
    private ?array $errorCodes = null;

    private string $currenciesSource = '';
    private ?array $currencies = null;

    private string $currencyDecimalsSource = '';
    private ?array $currencyDecimals = null;

    private string $paymentServicesSource = '';
    private ?array $paymentServices = null;

    private string $iso8583ResponseCodesSource = '';
    private ?array $iso8583ResponseCodes = null;

    private string $apiKeyTestSource = '';
    private string $apiKeyTest = '';

    /**
     * @return $this
     */
    public function addMethod(Method $method): self
    {
        $key = strtolower($method->definition->name);
        if (isset($this->methods[$key])) {
            throw new RuntimeException("Duplicated and incompatible method: {$key}");
        }
        $this->methods[$key] = $method;

        return $this;
    }

    /**
     * @return \MLocati\Nexi\Build\API\Method[]
     */
    public function getMethods(): array
    {
        return array_values($this->methods);
    }

    /**
     * @return $this
     */
    public function addEntity(
        string $preferredName,
        array $fields,
        bool $addGetOrCreate,
        string $see,
        $isQuery = false,
    ): Entity {
        $newEntity = new Entity(
            name: $preferredName,
            addGetOrCreate: $addGetOrCreate,
            see: $see,
            isQuery: $isQuery,
        );
        array_map(static fn (Field $field) => $newEntity->addField($field), $fields);
        $eligible = $this->getCompatibleEntities($fields);
        switch (count($eligible)) {
            case 0:
                $existing = $this->getEntityByName($preferredName);
                if ($existing !== null) {
                    throw new RuntimeException('Duplicated entity name detected');
                }
                $this->entities[] = $newEntity;

                return $newEntity;
            case 1:
                $eligible[0]->merge($newEntity);

                return $eligible[0];
        }
        throw new RuntimeException('More than one entity found!');
    }

    public function getEntityByName(string $name): ?Entity
    {
        $result = array_filter($this->entities, static fn (Entity $entity): bool => strcasecmp($name, $entity->name) === 0);
        switch (count($result)) {
            case 0:
                return null;
            case 1:
                return array_pop($result);
        }
        throw new RuntimeException('More than one entity found!');
    }
    /**
     * @param \MLocati\Nexi\Build\API\Field[] $fields
     *
     * @return \MLocati\Nexi\Build\API\Entity[]
     */
    public function getCompatibleEntities(array $fields): array
    {
        return array_values(
            array_filter(
                $this->entities,
                static fn (Entity $entity): bool => $entity->fieldsAre($fields)
            )
        );
    }

    /**
     * @return \MLocati\Nexi\Build\API\Entity[]
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    public function setWebookRequest(Webhook\Request $value): self
    {
        if ($this->webhookRequest !== null) {
            throw new RuntimeException('Duplicated webhook request');
        }
        $this->webhookRequest = $value;

        return $this;
    }

    public function getWebhookRequest(): ?Webhook\Request
    {
        return $this->webhookRequest;
    }

    public function setWebookResponse(Webhook\Response $value): self
    {
        if ($this->webhookResponse !== null) {
            throw new RuntimeException('Duplicated webhook response');
        }
        $this->webhookResponse = $value;

        return $this;
    }

    public function getWebhookResponse(): ?Webhook\Response
    {
        return $this->webhookResponse;
    }

    public function setBaseUrlTest(string $source, string $value): self
    {
        if ($this->baseUrlTest !== '' && $this->baseUrlTest !== $value) {
            throw new RuntimeException('Duplicated and incompatible test base URL');
        }
        $this->baseUrlTestSource = $source;
        $this->baseUrlTest = $value;

        return $this;
    }

    public function getBaseUrlTest(): string
    {
        return $this->baseUrlTest;
    }

    public function getBaseUrlTestSource(): string
    {
        return $this->baseUrlTestSource;
    }

    public function setBaseUrlProduction(string $source, string $value): self
    {
        if ($this->baseUrlProduction !== '' && $this->baseUrlProduction !== $value) {
            throw new RuntimeException('Duplicated and incompatible production base URL');
        }
        $this->baseUrlProductionSource = $source;
        $this->baseUrlProduction = $value;

        return $this;
    }

    public function getBaseUrlProduction(): string
    {
        return $this->baseUrlProduction;
    }

    public function getBaseUrlProductionSource(): string
    {
        return $this->baseUrlProductionSource;
    }

    public function setLanguages(string $source, array $value): self
    {
        if ($this->languages !== null && $this->languages !== $value) {
            throw new RuntimeException('Duplicated and incompatible language dictionary');
        }
        $this->languagesSource = $source;
        $this->languages = $value;

        return $this;
    }

    public function setApiKeyTest(string $source, string $value): self
    {
        if ($this->apiKeyTest !== '' && $this->apiKeyTest !== $value) {
            throw new RuntimeException('Duplicated and incompatible test API key');
        }
        $this->apiKeyTestSource = $source;
        $this->apiKeyTest = $value;

        return $this;
    }

    public function getApiKeyTest(): string
    {
        return $this->apiKeyTest;
    }

    public function getApiKeyTestSource(): string
    {
        return $this->apiKeyTestSource;
    }

    public function getLanguagesSource(): string
    {
        return $this->languagesSource;
    }

    public function getLanguages(): ?array
    {
        return $this->languages;
    }

    public function setErrorCodes(string $source, array $value): self
    {
        if ($this->errorCodes !== null && $this->errorCodes !== $value) {
            throw new RuntimeException('Duplicated and incompatible error codes');
        }
        $this->errorCodesSource = $source;
        $this->errorCodes = $value;

        return $this;
    }

    public function getErrorCodesSource(): string
    {
        return $this->errorCodesSource;
    }

    public function getErrorCodes(): ?array
    {
        return $this->errorCodes;
    }

    public function setCurrencies(string $source, array $value): self
    {
        if ($this->currencies !== null && $this->currencies !== $value) {
            throw new RuntimeException('Duplicated and incompatible currency dictionary');
        }
        $this->currenciesSource = $source;
        $this->currencies = $value;

        return $this;
    }

    public function getCurrenciesSource(): string
    {
        return $this->currenciesSource;
    }

    public function getCurrencies(): ?array
    {
        return $this->currencies;
    }

    public function setCurrencyDecimals(string $source, array $value): self
    {
        if ($this->currencyDecimals !== null && $this->currencyDecimals !== $value) {
            throw new RuntimeException('Duplicated and incompatible currency decimals');
        }
        $this->currencyDecimalsSource = $source;
        $this->currencyDecimals = $value;

        return $this;
    }

    public function getCurrencyDecimalsSource(): string
    {
        return $this->currencyDecimalsSource;
    }

    public function getCurrencyDecimals(): ?array
    {
        return $this->currencyDecimals;
    }

    public function setPaymentServices(string $source, array $value): self
    {
        if ($this->paymentServices !== null && $this->paymentServices !== $value) {
            throw new RuntimeException('Duplicated and incompatible payment service dictionary');
        }
        $this->paymentServicesSource = $source;
        $this->paymentServices = $value;

        return $this;
    }

    public function getPaymentServicesSource(): string
    {
        return $this->paymentServicesSource;
    }

    public function getPaymentServices(): ?array
    {
        return $this->paymentServices;
    }

    public function setISO8583ResponseCodes(string $source, array $value): self
    {
        if ($this->iso8583ResponseCodes !== null && $this->iso8583ResponseCodes !== $value) {
            throw new RuntimeException('Duplicated and incompatible ISO 8583 response codes');
        }
        $this->iso8583ResponseCodesSource = $source;
        $this->iso8583ResponseCodes = $value;

        return $this;
    }

    public function getISO8583ResponseCodes(): ?array
    {
        return $this->iso8583ResponseCodes;
    }

    public function finalizeEntities(): void
    {
        $this->resolveMethodTypes();
        $this->fixMethodEntityNames();
        $errorsEntity = $this->getEntityByName(self::ENTITYNAME_ERRORS);
        if ($errorsEntity?->name !== self::ENTITYNAME_ERRORS) {
            throw new RuntimeException(sprintf("The %s entity couldn't be found", self::ENTITYNAME_ERRORS));
        }
    }

    private function resolveMethodTypes(): void
    {
        foreach ($this->methods as $method) {
            $method->resolveTypes($this);
        }
    }

    private function fixMethodEntityNames(): void
    {
        $list = [];
        $add = static function (Entity $entity, string $description) use (&$list): void {
            $key = spl_object_hash($entity);
            if (isset($list[$key])) {
                $list[$key]['descriptions'][] = $description;
            } else {
                $list[$key] = ['entity' => $entity, 'descriptions' => [$description]];
            }
        };
        foreach ($this->methods as $method) {
            $type = $method->getQueryType();
            if ($type !== null) {
                $add($type->entity, "{$method->definition->name}/Query");
            }
            $type = $method->getBodyType();
            if ($type !== null) {
                $add($type->entity, "{$method->definition->name}/Request");
            }
            foreach ($method->getResponseTypes() as $code => $type) {
                if ($type !== null) {
                    $add($type->entity, "{$method->definition->name}/Response/{$code}");
                }
            }
        }
        array_map(fn (array $info) => $this->finalizeEntityName($info['entity'], $info['descriptions']), $list);
    }

    /**
     * @param string[] $descriptions
     */
    private function finalizeEntityName(Entity $entity, array $descriptions): void
    {
        if (count($descriptions) < 2) {
            return;
        }
        $fieldNames = array_map(static fn (Field $field): string => $field->name, $entity->getFields());
        sort($fieldNames, SORT_STRING);
        $fieldNames = implode('|', $fieldNames);
        $map = [
            /*
             * Used in many error responses
             */
            'errors' => self::ENTITYNAME_ERRORS,
            /*
             * Used in:
             * - createOrderForPayByLink/Response/200
             * - createPayByLinkForReservation/Response/200
             */
            'paymentLink|securityToken' => 'PayByLinkResponse',
            /*
             * Used in:
             * - twoSteps3DSInit/Request
             * - threeSteps3DSInit/Request
             */
            'card|exemptions|order|recurrence' => 'MultiStepInitRequest',
            /*
             * Used in:
             * - twoSteps3DSInit/Response/200
             * - threeSteps3DSInit/Response/200
             */
            'operation|threeDSAuthRequest|threeDSAuthUrl|threeDSEnrollmentStatus' => 'MultiStepInitResponse',
            /*
             * Used in:
             * - twoSteps3DSPayment/Request
             * - threeSteps3DSPayment/Request
             */
            'captureType|card|exemptions|operationId|order|recurrence|threeDSAuthData' => 'MultiStepPaymentRequest',
            /*
             * Used in:
             * - twoSteps3DSPayment/Response/200
             * - threeSteps3DSPayment/Response/200
             * - createOrderForMerchantInitiatedTransaction/Response/200
             * - cardVerification/Response/200
             * - createOrderForMotoPayment/Response/200
             * - createVirtualCartOrder/Response/200
             * - incrementOrder/Response/200
             * - delayedCharge/Response/200
             * - noShowCharge/Response/200
             */
            'operation' => 'OperationResult',
            /*
             * Used in:
             * - finalizeXPayBuildOrder/Request
             * - cancelXPayBuildOrder/Request
             * - getXPayBuildOrderStatus/Query
             */
            'sessionId' => 'Session',
            /*
             * Used in:
             * - refund/Request
             * - capture/Request
             */
            'amount|currency|description' => 'AmountWithDescription',
            /*
             * Used in:
             * - refund/Response/200
             * - capture/Response/200
             * - cancel/Response/200
             */
            'operationId|operationTime' => 'OperationInfo',
            /*
             * Used in:
             * - incrementOrder/Request
             * - delayedCharge/Request
             * - noShowCharge/Request
             */
            'amount|currency|description|originalOperationId' => 'ChangeAmountRequest',
            /*
             * Used in:
             * - createStructure/Request
             * - findStructures/Response/200
             * - findStructureById/Response/200
             */
            'structure' => 'StructureInfo',
            /*
             * Used in:
             * - noShowValidation/Request
             * - delayedChargeValidation/Request
             * - incrementOrderValidation/Request
             */
            'amount|currency|reservationId' => 'ReservationValidation',
            /*
             * Used in:
             * - toggleService/Request
             * - getService/Response/200
             */
            'enabled|serviceName|serviceTecId|terminalId' => 'ServiceRequest',
            /*
             * Used in:
             * - createCustomField/Request
             * - getCustomField/Response/200
             */
            'customFieldEnabled|customFieldOrd|customFieldTitle|customFieldTranslations|structureId' => 'CustomFieldDetails',
        ];
        $newName = $map[$fieldNames] ?? '';
        if ($newName === '') {
            throw new RuntimeException("Failed to find a the new name of the entity {$entity->name} used in:\n- " . implode("\n- ", $descriptions) . "\n\nFields: {$fieldNames}");
        }
        $existingEntity = $this->getEntityByName($newName);
        if ($existingEntity !== null && $existingEntity !== $entity) {
            throw new RuntimeException("Duplicated new name {$newName} of the entity {$entity->name} used in:\n- " . implode("\n- ", $descriptions));
        }
        $entity->name = $newName;
    }
}
