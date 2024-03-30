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
 * @see https://developer.nexi.it/en/api/post-operations-operationId-captures
 * @see https://developer.nexi.it/en/api/post-operations-operationId-refunds
 */
class AmountWithDescription extends Entity
{
    /**
     * Transaction amount in smallest currency unit. 5000 corresponds to 50,00 €. Expressed in the currency of the payment.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 100
     */
    public function getAmount(): ?string
    {
        return $this->_getString('amount');
    }

    /**
     * Transaction amount in smallest currency unit. 5000 corresponds to 50,00 €. Expressed in the currency of the payment.
     *
     * @optional
     *
     * @return $this
     *
     * @example 100
     */
    public function setAmount(?string $value): self
    {
        return $value === null ? $this->_unset('amount') : $this->_set('amount', $value);
    }

    /**
     * Transaction currency. ISO 4217 alphabetic code.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example EUR
     */
    public function getCurrency(): ?string
    {
        return $this->_getString('currency');
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
    public function setCurrency(?string $value): self
    {
        return $value === null ? $this->_unset('currency') : $this->_set('currency', $value);
    }

    /**
     * Free text message available to describe the rationale of the post operation.
     *
     * @optional
     * Maximum length: 255
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example goods have been shipped.
     */
    public function getDescription(): ?string
    {
        return $this->_getString('description');
    }

    /**
     * Free text message available to describe the rationale of the post operation.
     *
     * @optional
     * Maximum length: 255
     *
     * @return $this
     *
     * @example goods have been shipped.
     */
    public function setDescription(?string $value): self
    {
        return $value === null ? $this->_unset('description') : $this->_set('description', $value);
    }
}