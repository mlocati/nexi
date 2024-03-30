<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\FindRecurringContractsByCustomerId;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/get-contracts-customers-customerId
 */
class Response extends Entity
{
    /**
     * Customer ID.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 36451278
     */
    public function getCustomerId(): ?string
    {
        return $this->_getString('customerId');
    }

    /**
     * Customer ID.
     *
     * @optional
     *
     * @return $this
     *
     * @example 36451278
     */
    public function setCustomerId(?string $value): self
    {
        return $value === null ? $this->_unset('customerId') : $this->_set('customerId', $value);
    }

    /**
     * Array containing the contracts list.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\Entity\Contract[]|null
     */
    public function getContracts(): ?array
    {
        return $this->_getEntityArray('contracts', \MLocati\Nexi\Entity\Contract::class);
    }

    /**
     * Array containing the contracts list.
     *
     * @param \MLocati\Nexi\Entity\Contract[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setContracts(?array $value): self
    {
        return $value === null ? $this->_unset('contracts') : $this->_setEntityArray('contracts', \MLocati\Nexi\Entity\Contract::class, $value);
    }
}