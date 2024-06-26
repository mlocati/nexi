<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Entity;

use MLocati\Nexi\XPayWeb\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/get-build-state#tab_response
 * @see https://developer.nexi.it/en/api/get-operations#tab_response
 * @see https://developer.nexi.it/en/api/get-operations-operationId
 * @see https://developer.nexi.it/en/api/get-orders-orderId#tab_response
 * @see https://developer.nexi.it/en/api/get-reservations-reservationId#tab_response
 * @see https://developer.nexi.it/en/api/notifica#tab_body
 * @see https://developer.nexi.it/en/api/post-build-cancel#tab_response
 * @see https://developer.nexi.it/en/api/post-build-finalize-payment#tab_response
 * @see https://developer.nexi.it/en/api/post-delay_charges#tab_response
 * @see https://developer.nexi.it/en/api/post-incrementals#tab_response
 * @see https://developer.nexi.it/en/api/post-no_shows#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-2steps-init#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-2steps-payment#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-3steps-init#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-3steps-payment#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-3steps-validation#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-card_verification#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-mit#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-moto#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-virtual_card#tab_response
 */
class Operation extends Entity
{
    /**
     * Merchant order id, unique in the merchant domain.
     *
     * @optional
     * Maximum length: 18
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example btid2384983
     */
    public function getOrderId(): ?string
    {
        return $this->_getString('orderId');
    }

    /**
     * Merchant order id, unique in the merchant domain.
     *
     * @optional
     * Maximum length: 18
     *
     * @return $this
     *
     * @example btid2384983
     */
    public function setOrderId(?string $value): self
    {
        return $value === null ? $this->_unset('orderId') : $this->_set('orderId', $value);
    }

    /**
     * Operation ID.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example 3470744
     */
    public function getOperationId(): ?string
    {
        return $this->_getString('operationId');
    }

    /**
     * Operation ID.
     *
     * @optional
     *
     * @return $this
     *
     * @example 3470744
     */
    public function setOperationId(?string $value): self
    {
        return $value === null ? $this->_unset('operationId') : $this->_set('operationId', $value);
    }

    /**
     * It indicates the originating channel:
     * * ECOMMERCE - cardholder initiated operation through an online channel.
     * * POS - cardholder initiated operation through a physical POS.
     * * BACKOFFICE - merchant initiated operation. It includes post operations and MIT.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example ECOMMERCE
     */
    public function getChannel(): ?string
    {
        return $this->_getString('channel');
    }

    /**
     * It indicates the originating channel:
     * * ECOMMERCE - cardholder initiated operation through an online channel.
     * * POS - cardholder initiated operation through a physical POS.
     * * BACKOFFICE - merchant initiated operation. It includes post operations and MIT.
     *
     * @optional
     *
     * @return $this
     *
     * @example ECOMMERCE
     */
    public function setChannel(?string $value): self
    {
        return $value === null ? $this->_unset('channel') : $this->_set('channel', $value);
    }

    /**
     * It indicates the purpose of the request:
     * - AUTHORIZATION - payment authorization.
     * - CAPTURE - capture of the authorized amount.
     * - VOID - reversal of an authorization.
     * - REFUND - refund of a captured amount.
     * - CANCEL - the rollback of an capture, refund.
     * - CARD_VERIFICATION - verify operation, without any charge, with the sole purpose of confirming the validity of the card data entered by the customer.
     * - NOSHOW - noshow operation (reserved for Disputeless service).
     * - INCREMENTAL - incremental operation (reserved for Disputeless service).
     * - DELAY_CHARGE - delay charge operation (reserved for the Disputeless service).
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example CAPTURE
     */
    public function getOperationType(): ?string
    {
        return $this->_getString('operationType');
    }

    /**
     * It indicates the purpose of the request:
     * - AUTHORIZATION - payment authorization.
     * - CAPTURE - capture of the authorized amount.
     * - VOID - reversal of an authorization.
     * - REFUND - refund of a captured amount.
     * - CANCEL - the rollback of an capture, refund.
     * - CARD_VERIFICATION - verify operation, without any charge, with the sole purpose of confirming the validity of the card data entered by the customer.
     * - NOSHOW - noshow operation (reserved for Disputeless service).
     * - INCREMENTAL - incremental operation (reserved for Disputeless service).
     * - DELAY_CHARGE - delay charge operation (reserved for the Disputeless service).
     *
     * @optional
     *
     * @return $this
     *
     * @example CAPTURE
     */
    public function setOperationType(?string $value): self
    {
        return $value === null ? $this->_unset('operationType') : $this->_set('operationType', $value);
    }

    /**
     * Outcome of the operation:
     * * AUTHORIZED - Payment authorized
     * * EXECUTED - Payment confirmed, verification successfully executed
     * * DECLINED - Declined by the Issuer during the authorization phase
     * * DENIED_BY_RISK - Negative outcome of the transaction risk analysis
     * * THREEDS_VALIDATED - 3DS authentication OK or 3DS skipped (non-secure payment)
     * * THREEDS_FAILED - cancellation or authentication failure during 3DS
     * * PENDING - Payment ongoing. Follow up notifications are expected
     * * CANCELED - Canceled by the cardholder
     * * VOIDED - Online reversal of the full authorized amount
     * * REFUNDED - Full or partial amount refunded
     * * FAILED - Payment failed due to technical reasons
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example AUTHORIZED
     */
    public function getOperationResult(): ?string
    {
        return $this->_getString('operationResult');
    }

    /**
     * Outcome of the operation:
     * * AUTHORIZED - Payment authorized
     * * EXECUTED - Payment confirmed, verification successfully executed
     * * DECLINED - Declined by the Issuer during the authorization phase
     * * DENIED_BY_RISK - Negative outcome of the transaction risk analysis
     * * THREEDS_VALIDATED - 3DS authentication OK or 3DS skipped (non-secure payment)
     * * THREEDS_FAILED - cancellation or authentication failure during 3DS
     * * PENDING - Payment ongoing. Follow up notifications are expected
     * * CANCELED - Canceled by the cardholder
     * * VOIDED - Online reversal of the full authorized amount
     * * REFUNDED - Full or partial amount refunded
     * * FAILED - Payment failed due to technical reasons
     *
     * @optional
     *
     * @return $this
     *
     * @example AUTHORIZED
     */
    public function setOperationResult(?string $value): self
    {
        return $value === null ? $this->_unset('operationResult') : $this->_set('operationResult', $value);
    }

    /**
     * Operation time.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example 2022-09-01T01:20:00.001Z
     */
    public function getOperationTime(): ?string
    {
        return $this->_getString('operationTime');
    }

    /**
     * Operation time.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2022-09-01T01:20:00.001Z
     */
    public function setOperationTime(?string $value): self
    {
        return $value === null ? $this->_unset('operationTime') : $this->_set('operationTime', $value);
    }

    /**
     * * CARD - Any card circuit
     * * APM - Alternative payment method
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example CARD
     */
    public function getPaymentMethod(): ?string
    {
        return $this->_getString('paymentMethod');
    }

    /**
     * * CARD - Any card circuit
     * * APM - Alternative payment method
     *
     * @optional
     *
     * @return $this
     *
     * @example CARD
     */
    public function setPaymentMethod(?string $value): self
    {
        return $value === null ? $this->_unset('paymentMethod') : $this->_set('paymentMethod', $value);
    }

    /**
     * one of the payment circuit values returned by the GET payment_methods web service VISA, MC, AMEX, DINERS, GOOGLE_PAY, APPLE_PAY, PAYPAL, BANCONTACT, BANCOMAT_PAY, MYBANK, PIS, AMAZON_PAY, ALIPAY etc.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example VISA
     */
    public function getPaymentCircuit(): ?string
    {
        return $this->_getString('paymentCircuit');
    }

    /**
     * one of the payment circuit values returned by the GET payment_methods web service VISA, MC, AMEX, DINERS, GOOGLE_PAY, APPLE_PAY, PAYPAL, BANCONTACT, BANCOMAT_PAY, MYBANK, PIS, AMAZON_PAY, ALIPAY etc.
     *
     * @optional
     *
     * @return $this
     *
     * @example VISA
     */
    public function setPaymentCircuit(?string $value): self
    {
        return $value === null ? $this->_unset('paymentCircuit') : $this->_set('paymentCircuit', $value);
    }

    /**
     * Payment instrument information.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example ***6152
     */
    public function getPaymentInstrumentInfo(): ?string
    {
        return $this->_getString('paymentInstrumentInfo');
    }

    /**
     * Payment instrument information.
     *
     * @optional
     *
     * @return $this
     *
     * @example ***6152
     */
    public function setPaymentInstrumentInfo(?string $value): self
    {
        return $value === null ? $this->_unset('paymentInstrumentInfo') : $this->_set('paymentInstrumentInfo', $value);
    }

    /**
     * It is defined by the circuit to uniquely identify the transaction. Required for circuid reconciliation purposes.
     *
     * @optional
     * Maximum length: 35
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example e723hedsdew
     */
    public function getPaymentEndToEndId(): ?string
    {
        return $this->_getString('paymentEndToEndId');
    }

    /**
     * It is defined by the circuit to uniquely identify the transaction. Required for circuid reconciliation purposes.
     *
     * @optional
     * Maximum length: 35
     *
     * @return $this
     *
     * @example e723hedsdew
     */
    public function setPaymentEndToEndId(?string $value): self
    {
        return $value === null ? $this->_unset('paymentEndToEndId') : $this->_set('paymentEndToEndId', $value);
    }

    /**
     * Operation ID to be undone.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example 321312
     */
    public function getCancelledOperationId(): ?string
    {
        return $this->_getString('cancelledOperationId');
    }

    /**
     * Operation ID to be undone.
     *
     * @optional
     *
     * @return $this
     *
     * @example 321312
     */
    public function setCancelledOperationId(?string $value): self
    {
        return $value === null ? $this->_unset('cancelledOperationId') : $this->_set('cancelledOperationId', $value);
    }

    /**
     * Operation amount in the payment currency.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example 3545
     */
    public function getOperationAmount(): ?string
    {
        return $this->_getString('operationAmount');
    }

    /**
     * Operation amount in the payment currency.
     *
     * @optional
     *
     * @return $this
     *
     * @example 3545
     */
    public function setOperationAmount(?string $value): self
    {
        return $value === null ? $this->_unset('operationAmount') : $this->_set('operationAmount', $value);
    }

    /**
     * Transaction currency. ISO 4217 alphabetic code.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example EUR
     */
    public function getOperationCurrency(): ?string
    {
        return $this->_getString('operationCurrency');
    }

    /**
     * Transaction currency. ISO 4217 alphabetic code.
     *
     * @optional
     *
     * @return $this
     *
     * @example EUR
     */
    public function setOperationCurrency(?string $value): self
    {
        return $value === null ? $this->_unset('operationCurrency') : $this->_set('operationCurrency', $value);
    }

    /**
     * Object containing the customer detail. Sending the content of this object increases the security level of the transaction, thus increasing the probability that two-factor authentication will not be requested in the payment.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     */
    public function getCustomerInfo(): ?CustomerInfo
    {
        return $this->_getEntity('customerInfo', CustomerInfo::class);
    }

    /**
     * Object containing the customer detail. Sending the content of this object increases the security level of the transaction, thus increasing the probability that two-factor authentication will not be requested in the payment.
     *
     * @optional
     *
     * @return $this
     */
    public function setCustomerInfo(?CustomerInfo $value): self
    {
        return $value === null ? $this->_unset('customerInfo') : $this->_set('customerInfo', $value);
    }

    /**
     * Array containing the list of warnings.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\XPayWeb\Entity\Error[]|null
     */
    public function getWarnings(): ?array
    {
        return $this->_getEntityArray('warnings', Error::class);
    }

    /**
     * Array containing the list of warnings.
     *
     * @param \MLocati\Nexi\XPayWeb\Entity\Error[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setWarnings(?array $value): self
    {
        return $value === null ? $this->_unset('warnings') : $this->_setEntityArray('warnings', Error::class, $value);
    }

    /**
     * PayByLink ID used for correlating this operation with the original link.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example 234244353
     */
    public function getPaymentLinkId(): ?string
    {
        return $this->_getString('paymentLinkId');
    }

    /**
     * PayByLink ID used for correlating this operation with the original link.
     *
     * @optional
     *
     * @return $this
     *
     * @example 234244353
     */
    public function setPaymentLinkId(?string $value): self
    {
        return $value === null ? $this->_unset('paymentLinkId') : $this->_set('paymentLinkId', $value);
    }

    /**
     * Map of additional fields specific to the chosen payment method.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @return object|array|null
     *
     * @example {"authorizationCode":"647189","cardCountry":"ITA","threeDS":"FULL_SECURE","schemaTID":"MCS01198U","multiCurrencyConversion":{"amount":"2662","currency":"JPY","exchangeRate":"0.007510523"}}
     */
    public function getAdditionalData()
    {
        return $this->_getCustomObject('additionalData');
    }

    /**
     * Map of additional fields specific to the chosen payment method.
     *
     * @param object|array|null $value
     *
     * @optional
     *
     * @return $this
     *
     * @example {"authorizationCode":"647189","cardCountry":"ITA","threeDS":"FULL_SECURE","schemaTID":"MCS01198U","multiCurrencyConversion":{"amount":"2662","currency":"JPY","exchangeRate":"0.007510523"}}
     */
    public function setAdditionalData($value): self
    {
        return $value === null ? $this->_unset('additionalData') : $this->_setCustomObject('additionalData', $value);
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\XPayWeb\Entity::getRequiredFields()
     */
    protected function getRequiredFields(): array
    {
        return [
        ];
    }
}
