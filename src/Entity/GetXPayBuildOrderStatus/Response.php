<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Entity\GetXPayBuildOrderStatus;

use MLocati\Nexi\XPayWeb\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/get-build-state
 */
class Response extends Entity
{
    /**
     * Transaction status. Possible values:
     * - CARD_DATA_COLLECTION: the customer has chosen payment by card. The "fieldSet" object containing the iframes for collecting the card data is returned.
     * - PAYMENT_METHOD_SELECTION: the customer must proceed with the choice of payment method. The "fieldSet" object containing the payment method iframes is returned.
     * - READY_FOR_PAYMENT: payment ready to be executed, it is necessary to call the API POST /build/finalize_payment.
     * - REDIRECTED_TO_EXTERNAL_DOMAIN - The url to perform 3D Secure authentication has been provided. The "url" parameter is returned.
     * - PAYMENT_COMPLETE: Payment has been completed. The "operation" object is returned.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     */
    public function getState(): ?string
    {
        return $this->_getString('state');
    }

    /**
     * Transaction status. Possible values:
     * - CARD_DATA_COLLECTION: the customer has chosen payment by card. The "fieldSet" object containing the iframes for collecting the card data is returned.
     * - PAYMENT_METHOD_SELECTION: the customer must proceed with the choice of payment method. The "fieldSet" object containing the payment method iframes is returned.
     * - READY_FOR_PAYMENT: payment ready to be executed, it is necessary to call the API POST /build/finalize_payment.
     * - REDIRECTED_TO_EXTERNAL_DOMAIN - The url to perform 3D Secure authentication has been provided. The "url" parameter is returned.
     * - PAYMENT_COMPLETE: Payment has been completed. The "operation" object is returned.
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
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
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
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     */
    public function getOperation(): ?\MLocati\Nexi\XPayWeb\Entity\Operation
    {
        return $this->_getEntity('operation', \MLocati\Nexi\XPayWeb\Entity\Operation::class);
    }

    /**
     * Object containing operation detail.
     *
     * @optional
     *
     * @return $this
     */
    public function setOperation(?\MLocati\Nexi\XPayWeb\Entity\Operation $value): self
    {
        return $value === null ? $this->_unset('operation') : $this->_set('operation', $value);
    }

    /**
     * Oggetto contentente gli iframe per la scelta dei metodi di pagamento o per la raccolta dati carta.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\XPayWeb\Exception\WrongFieldType
     */
    public function getFieldSet(): ?\MLocati\Nexi\XPayWeb\Entity\FieldSet
    {
        return $this->_getEntity('fieldSet', \MLocati\Nexi\XPayWeb\Entity\FieldSet::class);
    }

    /**
     * Oggetto contentente gli iframe per la scelta dei metodi di pagamento o per la raccolta dati carta.
     *
     * @optional
     *
     * @return $this
     */
    public function setFieldSet(?\MLocati\Nexi\XPayWeb\Entity\FieldSet $value): self
    {
        return $value === null ? $this->_unset('fieldSet') : $this->_set('fieldSet', $value);
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
