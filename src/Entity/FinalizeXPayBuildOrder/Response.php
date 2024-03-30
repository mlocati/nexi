<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\FinalizeXPayBuildOrder;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/post-build-finalize-payment
 */
class Response extends Entity
{
    /**
     * Stato della transazione. Valori possibili:
     * - REDIRECTED_TO_EXTERNAL_DOMAIN
     * - PAYMENT_COMPLETE
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getState(): ?string
    {
        return $this->_getString('state');
    }

    /**
     * Stato della transazione. Valori possibili:
     * - REDIRECTED_TO_EXTERNAL_DOMAIN
     * - PAYMENT_COMPLETE
     *
     * @optional
     *
     * @return $this
     */
    public function setState(?string $value): self
    {
        return $value === null ? $this->_unset('state') : $this->_set('state', $value);
    }

    /**
     * Address for 3D Secure authentication. This parameter is returned if the "state" parameter is set to "REDIRECTED_TO_EXTERNAL_DOMAIN".
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example https://{3DS-Ares-Url}
     */
    public function getUrl(): ?string
    {
        return $this->_getString('url');
    }

    /**
     * Address for 3D Secure authentication. This parameter is returned if the "state" parameter is set to "REDIRECTED_TO_EXTERNAL_DOMAIN".
     *
     * @optional
     *
     * @return $this
     *
     * @example https://{3DS-Ares-Url}
     */
    public function setUrl(?string $value): self
    {
        return $value === null ? $this->_unset('url') : $this->_set('url', $value);
    }

    /**
     * Object containing operation detail.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getOperation(): ?\MLocati\Nexi\Entity\Operation
    {
        return $this->_getEntity('operation', \MLocati\Nexi\Entity\Operation::class);
    }

    /**
     * Object containing operation detail.
     *
     * @optional
     *
     * @return $this
     */
    public function setOperation(?\MLocati\Nexi\Entity\Operation $value): self
    {
        return $value === null ? $this->_unset('operation') : $this->_set('operation', $value);
    }
}