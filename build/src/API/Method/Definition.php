<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\API\Method;

use MLocati\Nexi\XPayWeb\Build\API\Verb;

class Definition
{
    public const WEBHOOK_REQUEST = 'webhookRequest';
    public const WEBHOOK_RESPONSE = 'webhookResponse';

    private const DEFINITIONS_BY_PATH = [
        'POST@/orders/hpp' => [
            'name' => 'createOrderForHostedPayment',
        ],
        'POST@/orders/paybylink' => [
            'name' => 'createOrderForPayByLink',
        ],
        'POST@/paybylink/{linkId}/cancels' => [
            'name' => 'cancelPayByLink',
        ],
        'POST@/orders/2steps/init' => [
            'name' => 'twoSteps3DSInit',
        ],
        'POST@/orders/2steps/payment' => [
            'name' => 'twoSteps3DSPayment',
        ],
        'POST@/orders/3steps/init' => [
            'name' => 'threeSteps3DSInit',
        ],
        'POST@/orders/3steps/validation' => [
            'name' => 'threeSteps3DSValidation',
        ],
        'POST@/orders/3steps/payment' => [
            'name' => 'threeSteps3DSPayment',
        ],
        'POST@/orders/mit' => [
            'name' => 'createOrderForMerchantInitiatedTransaction',
        ],
        'POST@/orders/card_verification' => [
            'name' => 'cardVerification',
        ],
        'POST@/orders/moto' => [
            'name' => 'createOrderForMotoPayment',
        ],
        'POST@/orders/virtual_card' => [
            'name' => 'createVirtualCartOrder',
        ],
        'POST@/orders/build' => [
            'name' => 'createXPayBuildOrder',
        ],
        'POST@/build/finalize_payment' => [
            'name' => 'finalizeXPayBuildOrder',
        ],
        'POST@/build/cancel' => [
            'name' => 'cancelXPayBuildOrder',
        ],
        'GET@/build/state' => [
            'name' => 'getXPayBuildOrderStatus',
        ],
        'GET@/orders' => [
            'name' => 'findOrders',
            'entityNames' => [
                'responseBody' => [
                    200 => [
                        'orders' => 'OrderDetails',
                    ],
                ],
            ],
        ],
        'GET@/orders/{orderId}' => [
            'name' => 'findOrderById',
        ],
        'GET@/operations' => [
            'name' => 'findOperations',
        ],
        'GET@/operations/{operationId}' => [
            'name' => 'findOperationById',
        ],
        'GET@/operations/{operationId}/actions' => [
            'name' => 'getOperationActions',
        ],
        'POST@/operations/{operationId}/refunds' => [
            'name' => 'refund',
        ],
        'POST@/operations/{operationId}/captures' => [
            'name' => 'capture',
        ],
        'POST@/operations/{operationId}/cancels' => [
            'name' => 'cancel',
        ],
        'GET@/contracts/customers/{customerId}' => [
            'name' => 'findRecurringContractsByCustomerId',
        ],
        'POST@/contracts/{contractId}/deactivation' => [
            'name' => 'disableContract',
        ],
        'POST@/payment_methods' => [
            'name' => 'listSupportedPaymentMethods',
            'overrideWrongVerb' => Verb::GET,
        ],
        'POST@/termsAndConditions' => [
            'name' => 'createTermsAndConditions',
        ],
        'GET@/terms_and_conditions/{termsAndConditionsId}' => [
            'name' => 'findTermsAndConditionsById',
        ],
        'POST@/incrementals' => [
            'name' => 'incrementOrder',
        ],
        'POST@/terms_and_conditions/{termsAndConditionsId}/cancels' => [
            'name' => 'cancelTermsAndConditions',
        ],
        'POST@/delay_charges' => [
            'name' => 'delayedCharge',
        ],
        'POST@/no_shows' => [
            'name' => 'noShowCharge',
        ],
        'POST@/reservations' => [
            'name' => 'createReservation',
        ],
        'GET@/reservations' => [
            'name' => 'findReservations',
        ],
        'POST@/reservations/{reservationId}/paybylink' => [
            'name' => 'createPayByLinkForReservation',
        ],
        'GET@/reservations/{reservationId}' => [
            'name' => 'findReservationById',
        ],
        'POST@/structures' => [
            'name' => 'createStructure',
        ],
        'GET@/structures' => [
            'name' => 'findStructures',
        ],
        'GET@/structures/{structureId}' => [
            'name' => 'findStructureById',
        ],
        'POST@/noshow_validation' => [
            'name' => 'noShowValidation',
        ],
        'POST@/delaycharge_validation' => [
            'name' => 'delayedChargeValidation',
        ],
        'POST@/incremental_validation' => [
            'name' => 'incrementOrderValidation',
        ],
        'POST@/structure_conditions' => [
            'name' => 'createStructureTermsAndConditions',
            'entityNames' => [
                'requestBody' => [
                    'termsAndConditions' => 'StructureTermsAndConditionsDetails',
                ],
            ],
        ],
        'GET@/structure_conditions/structures/{structureid}' => [
            'name' => 'findStructureTermsAndConditionsByStructureId',
            'entityNames' => [
                'responseBody' => [
                    200 => [
                        '' => 'StructureTermsAndConditions',
                    ],
                ],
            ],
        ],
        'GET@/structure_conditions/{structureConditionId}' => [
            'name' => 'findStructureTermsAndConditionsById',
            'entityNames' => [
                'responseBody' => [
                    200 => [
                        'termsAndConditions' => 'StructureTermsAndConditionsDetails',
                    ],
                ],
            ],
        ],
        'POST@/structure_conditions/{structureConditionId}/cancels' => [
            'name' => 'cancelStructureTermsAndConditions',
        ],
        'POST@/services' => [
            'name' => 'toggleService',
        ],
        'GET@/services' => [
            'name' => 'getService',
        ],
        'POST@/custom_fields' => [
            'name' => 'createCustomField',
        ],
        'GET@/custom_fields/{customFieldId}' => [
            'name' => 'getCustomField',
        ],
        'GET@/structure_conditions/{structureConditionId}/pdf' => [
            'name' => 'getStructureTermsAndConditionsPdf',
        ],
        'POST@/reservation/{reservationId}/mit' => [
            'name' => 'payRecurringReservation',
        ],
    ];

    public readonly string $name;

    public readonly ?Verb $overrideWrongVerb;

    private readonly array $entityNames;

    private function __construct(
        array $data,
    ) {
        $this->name = $data['name'];
        $this->entityNames = $data['entityNames'] ?? [];
        $this->overrideWrongVerb = $data['overrideWrongVerb'] ?? null;
    }

    public static function getByVerbAndPath(Verb $verb, string $path): ?self
    {
        $key = "{$verb->value}@{$path}";
        $data = self::DEFINITIONS_BY_PATH[$key] ?? null;

        return $data === null ? null : new self($data);
    }

    public static function getForWebhookRequest(): ?self
    {
        return new self([
            'name' => self::WEBHOOK_REQUEST,
        ]);
    }

    public static function getForWebhookResponse(): ?self
    {
        return new self([
            'name' => self::WEBHOOK_RESPONSE,
        ]);
    }

    public function getRequestBodyEntityNames(): array
    {
        return $this->entityNames['requestBody'] ?? [];
    }

    public function getResponseBodyEntityNames(int|string $httpStatusCode): array
    {
        return $this->entityNames['responseBody'][$httpStatusCode] ?? [];
    }
}
