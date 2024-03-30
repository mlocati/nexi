<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\ThreeSteps3DSValidation;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/post-orders-3steps-validation
 */
class Request extends Entity
{
    /**
     * Identifier of the payment pending.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 3470744
     */
    public function getOperationId(): ?string
    {
        return $this->_getString('operationId');
    }

    /**
     * Identifier of the payment pending.
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
     * Encrypted message containing the 3DS authentication result.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example ni2178hiekh29830...
     */
    public function getThreeDSAuthResponse(): ?string
    {
        return $this->_getString('threeDSAuthResponse');
    }

    /**
     * Encrypted message containing the 3DS authentication result.
     *
     * @optional
     *
     * @return $this
     *
     * @example ni2178hiekh29830...
     */
    public function setThreeDSAuthResponse(?string $value): self
    {
        return $value === null ? $this->_unset('threeDSAuthResponse') : $this->_set('threeDSAuthResponse', $value);
    }
}
