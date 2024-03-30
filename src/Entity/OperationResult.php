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
 * @see https://developer.nexi.it/en/api/post-delay_charges
 * @see https://developer.nexi.it/en/api/post-incrementals
 * @see https://developer.nexi.it/en/api/post-no_shows
 * @see https://developer.nexi.it/en/api/post-orders-2steps-payment
 * @see https://developer.nexi.it/en/api/post-orders-3steps-payment
 * @see https://developer.nexi.it/en/api/post-orders-card_verification
 * @see https://developer.nexi.it/en/api/post-orders-mit
 * @see https://developer.nexi.it/en/api/post-orders-moto
 * @see https://developer.nexi.it/en/api/post-orders-virtual_card
 */
class OperationResult extends Entity
{
    /**
     * Object containing operation detail.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getOperation(): ?Operation
    {
        return $this->_getEntity('operation', Operation::class);
    }

    /**
     * Object containing operation detail.
     *
     * @optional
     *
     * @return $this
     */
    public function setOperation(?Operation $value): self
    {
        return $value === null ? $this->_unset('operation') : $this->_set('operation', $value);
    }
}