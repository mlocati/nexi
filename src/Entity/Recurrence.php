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
 * @see https://developer.nexi.it/en/api/post-orders-2steps-init#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-2steps-payment#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-3steps-init#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-3steps-payment#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-build#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-hpp#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-paybylink#tab_body
 */
class Recurrence extends Entity
{
    /**
     * Defines the type of contract to use for payment:
     * * NO_RECURRING - without contract
     * * SUBSEQUENT_PAYMENT - use of an already created contract
     * * CONTRACT_CREATION - contract creation
     * * CARD_SUBSTITUTION -
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example NO_RECURRING
     */
    public function getAction(): ?string
    {
        return $this->_getString('action');
    }

    /**
     * Defines the type of contract to use for payment:
     * * NO_RECURRING - without contract
     * * SUBSEQUENT_PAYMENT - use of an already created contract
     * * CONTRACT_CREATION - contract creation
     * * CARD_SUBSTITUTION -
     *
     * @optional
     *
     * @return $this
     *
     * @example NO_RECURRING
     */
    public function setAction(?string $value): self
    {
        return $value === null ? $this->_unset('action') : $this->_set('action', $value);
    }

    /**
     * Contract ID.
     *
     * @optional
     * Minimum length: 1
     * Maximum length: 18
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example C2834987
     */
    public function getContractId(): ?string
    {
        return $this->_getString('contractId');
    }

    /**
     * Contract ID.
     *
     * @optional
     * Minimum length: 1
     * Maximum length: 18
     *
     * @return $this
     *
     * @example C2834987
     */
    public function setContractId(?string $value): self
    {
        return $value === null ? $this->_unset('contractId') : $this->_set('contractId', $value);
    }

    /**
     * * MIT_UNSCHEDULED - once the card has been tokenized, the merchant will carry out subsequent charges with an undefined frequency
     * * MIT_SCHEDULED - once the card has been tokenized, the merchant will carry out subsequent debits with a defined frequency (eg first of each month)
     * * CIT - the card is tokenized to allow the cardholder to make subsequent payments faster. Unlike MIT transactions, the merchant will not have the ability to make direct debits on these tokenized cards, as the subsequent CIT payment is subject to authentication (SCA) by the cardholder
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example MIT_UNSCHEDULED
     */
    public function getContractType(): ?string
    {
        return $this->_getString('contractType');
    }

    /**
     * * MIT_UNSCHEDULED - once the card has been tokenized, the merchant will carry out subsequent charges with an undefined frequency
     * * MIT_SCHEDULED - once the card has been tokenized, the merchant will carry out subsequent debits with a defined frequency (eg first of each month)
     * * CIT - the card is tokenized to allow the cardholder to make subsequent payments faster. Unlike MIT transactions, the merchant will not have the ability to make direct debits on these tokenized cards, as the subsequent CIT payment is subject to authentication (SCA) by the cardholder
     *
     * @optional
     *
     * @return $this
     *
     * @example MIT_UNSCHEDULED
     */
    public function setContractType(?string $value): self
    {
        return $value === null ? $this->_unset('contractType') : $this->_set('contractType', $value);
    }

    /**
     * Used with contractType MIT_SCHEDULED.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2023-03-16
     */
    public function getContractExpiryDate(): ?string
    {
        return $this->_getString('contractExpiryDate');
    }

    /**
     * Used with contractType MIT_SCHEDULED.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2023-03-16
     */
    public function setContractExpiryDate(?string $value): self
    {
        return $value === null ? $this->_unset('contractExpiryDate') : $this->_set('contractExpiryDate', $value);
    }

    /**
     * Used with contractType MIT_SCHEDULED. Number of days.
     *
     * @optional
     * Maximum length: 4
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 120
     */
    public function getContractFrequency(): ?string
    {
        return $this->_getString('contractFrequency');
    }

    /**
     * Used with contractType MIT_SCHEDULED. Number of days.
     *
     * @optional
     * Maximum length: 4
     *
     * @return $this
     *
     * @example 120
     */
    public function setContractFrequency(?string $value): self
    {
        return $value === null ? $this->_unset('contractFrequency') : $this->_set('contractFrequency', $value);
    }
}
