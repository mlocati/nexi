<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/get-orders#tab_response
 * @see https://developer.nexi.it/en/api/get-orders-orderId#tab_response
 */
class OrderDetails extends Entity
{
    /**
     * Object containing the detail of the order.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getOrder(): ?Order
    {
        return $this->_getEntity('order', Order::class);
    }

    /**
     * Object containing the detail of the order.
     *
     * @optional
     *
     * @return $this
     */
    public function setOrder(?Order $value): self
    {
        return $value === null ? $this->_unset('order') : $this->_set('order', $value);
    }

    /**
     * Authorized amount.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 3545
     */
    public function getAuthorizedAmount(): ?string
    {
        return $this->_getString('authorizedAmount');
    }

    /**
     * Authorized amount.
     *
     * @optional
     *
     * @return $this
     *
     * @example 3545
     */
    public function setAuthorizedAmount(?string $value): self
    {
        return $value === null ? $this->_unset('authorizedAmount') : $this->_set('authorizedAmount', $value);
    }

    /**
     * Captured amount.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 3545
     */
    public function getCapturedAmount(): ?string
    {
        return $this->_getString('capturedAmount');
    }

    /**
     * Captured amount.
     *
     * @optional
     *
     * @return $this
     *
     * @example 3545
     */
    public function setCapturedAmount(?string $value): self
    {
        return $value === null ? $this->_unset('capturedAmount') : $this->_set('capturedAmount', $value);
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
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example CAPTURE
     */
    public function getLastOperationType(): ?string
    {
        return $this->_getString('lastOperationType');
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
    public function setLastOperationType(?string $value): self
    {
        return $value === null ? $this->_unset('lastOperationType') : $this->_set('lastOperationType', $value);
    }

    /**
     * Operation time.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2022-08-01T16:32:22.038Z
     */
    public function getLastOperationTime(): ?string
    {
        return $this->_getString('lastOperationTime');
    }

    /**
     * Operation time.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2022-08-01T16:32:22.038Z
     */
    public function setLastOperationTime(?string $value): self
    {
        return $value === null ? $this->_unset('lastOperationTime') : $this->_set('lastOperationTime', $value);
    }
}
