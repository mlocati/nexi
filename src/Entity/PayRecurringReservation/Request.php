<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Entity\PayRecurringReservation;

use MLocati\Nexi\XPayWeb\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/post-reservation-reservationId-mit
 */
class Request extends Entity
{
    /**
     * Transaction amount in smallest currency unit. 50 EUR is represented as 5000 (2 decimals) 50 JPY is represented as 50 (0 decimals).
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     *
     * @example 3545
     */
    public function getAmount(): ?string
    {
        return $this->_getString('amount');
    }

    /**
     * Transaction amount in smallest currency unit. 50 EUR is represented as 5000 (2 decimals) 50 JPY is represented as 50 (0 decimals).
     *
     * @optional
     *
     * @return $this
     *
     * @example 3545
     */
    public function setAmount(?string $value): self
    {
        return $value === null ? $this->_unset('amount') : $this->_set('amount', $value);
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
