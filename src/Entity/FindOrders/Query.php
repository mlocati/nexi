<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\FindOrders;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/get-orders
 */
class Query extends Entity implements \MLocati\Nexi\Service\QueryEntityInterface
{
    use \MLocati\Nexi\Service\QueryEntityTrait;

    /**
     * Identification code sent during the payment initialization phase (it must be unique).
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example btid2384983
     */
    public function getOrderId(): ?string
    {
        return $this->_getString('orderId');
    }

    /**
     * Identification code sent during the payment initialization phase (it must be unique).
     *
     * @optional
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
     * Search amount type. Possible values:
     * - ORDER_AMOUNT: total order amount.
     * - AUTHORIZED_AMOUNT: authorized amount.
     * - CAPTURED_AMOUNT: amount captured.
     *
     * @default ORDER_AMOUNT
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getAmountType(): ?string
    {
        return $this->_getString('amountType');
    }

    /**
     * Search amount type. Possible values:
     * - ORDER_AMOUNT: total order amount.
     * - AUTHORIZED_AMOUNT: authorized amount.
     * - CAPTURED_AMOUNT: amount captured.
     *
     * @default ORDER_AMOUNT
     *
     * @optional
     *
     * @return $this
     */
    public function setAmountType(?string $value): self
    {
        return $value === null ? $this->_unset('amountType') : $this->_set('amountType', $value);
    }

    /**
     * Retrieve orders with the defined minimum amount. Required if 'amountType' is sent.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 10
     */
    public function getMinAmount(): ?string
    {
        return $this->_getString('minAmount');
    }

    /**
     * Retrieve orders with the defined minimum amount. Required if 'amountType' is sent.
     *
     * @optional
     *
     * @return $this
     *
     * @example 10
     */
    public function setMinAmount(?string $value): self
    {
        return $value === null ? $this->_unset('minAmount') : $this->_set('minAmount', $value);
    }

    /**
     * Retrieve orders with the defined maximum amount. Required if 'amountType' is sent.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 50
     */
    public function getMaxAmount(): ?string
    {
        return $this->_getString('maxAmount');
    }

    /**
     * Retrieve orders with the defined maximum amount. Required if 'amountType' is sent.
     *
     * @optional
     *
     * @return $this
     *
     * @example 50
     */
    public function setMaxAmount(?string $value): self
    {
        return $value === null ? $this->_unset('maxAmount') : $this->_set('maxAmount', $value);
    }

    /**
     * Retrieve orders created from this time. ISO 8601 format. Example 2022-01-01T13:10:00.000Z.
     *
     * @default one month before the current time
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2022-01-01T13:10:00.000Z
     */
    public function getFromTime(): ?string
    {
        return $this->_getString('fromTime');
    }

    /**
     * Retrieve orders created from this time. ISO 8601 format. Example 2022-01-01T13:10:00.000Z.
     *
     * @default one month before the current time
     *
     * @optional
     *
     * @return $this
     *
     * @example 2022-01-01T13:10:00.000Z
     */
    public function setFromTime(?string $value): self
    {
        return $value === null ? $this->_unset('fromTime') : $this->_set('fromTime', $value);
    }

    /**
     * Retrieve orders up to this time. ISO 8601 format A maximum interval of one month is allowed. Example 2022-01-01T13:10:00.000Z.
     *
     * @default current time
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2022-01-02T00:00:00.000Z
     */
    public function getToTime(): ?string
    {
        return $this->_getString('toTime');
    }

    /**
     * Retrieve orders up to this time. ISO 8601 format A maximum interval of one month is allowed. Example 2022-01-01T13:10:00.000Z.
     *
     * @default current time
     *
     * @optional
     *
     * @return $this
     *
     * @example 2022-01-02T00:00:00.000Z
     */
    public function setToTime(?string $value): self
    {
        return $value === null ? $this->_unset('toTime') : $this->_set('toTime', $value);
    }

    /**
     * Search by order status. Possible values:
     * - TO_CAPTURE: authorized order, not yet accounted for.
     * - CAPTURED: authorized and accounted for order.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getOrderState(): ?string
    {
        return $this->_getString('orderState');
    }

    /**
     * Search by order status. Possible values:
     * - TO_CAPTURE: authorized order, not yet accounted for.
     * - CAPTURED: authorized and accounted for order.
     *
     * @optional
     *
     * @return $this
     */
    public function setOrderState(?string $value): self
    {
        return $value === null ? $this->_unset('orderState') : $this->_set('orderState', $value);
    }

    /**
     * How many items to be returned in one search. For the next page to set toTime equal to the lastOperationTime value of the last record in previous search.
     *
     * @default 20
     *
     * @optional
     * Maximum: 500
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 20
     */
    public function getMaxRecords(): ?int
    {
        return $this->_getInt('maxRecords');
    }

    /**
     * How many items to be returned in one search. For the next page to set toTime equal to the lastOperationTime value of the last record in previous search.
     *
     * @default 20
     *
     * @optional
     * Maximum: 500
     *
     * @return $this
     *
     * @example 20
     */
    public function setMaxRecords(?int $value): self
    {
        return $value === null ? $this->_unset('maxRecords') : $this->_set('maxRecords', $value);
    }

    /**
     * Search through additional parameters.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getCustomField(): ?string
    {
        return $this->_getString('customField');
    }

    /**
     * Search through additional parameters.
     *
     * @optional
     *
     * @return $this
     */
    public function setCustomField(?string $value): self
    {
        return $value === null ? $this->_unset('customField') : $this->_set('customField', $value);
    }
}
