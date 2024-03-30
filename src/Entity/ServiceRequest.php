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
 * @see https://developer.nexi.it/en/api/get-services
 * @see https://developer.nexi.it/en/api/post-services
 */
class ServiceRequest extends Entity
{
    /**
     * The service that merchant need to activate or deactivate.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example DISPUTELESS
     */
    public function getServiceName(): ?string
    {
        return $this->_getString('serviceName');
    }

    /**
     * The service that merchant need to activate or deactivate.
     *
     * @optional
     *
     * @return $this
     *
     * @example DISPUTELESS
     */
    public function setServiceName(?string $value): self
    {
        return $value === null ? $this->_unset('serviceName') : $this->_set('serviceName', $value);
    }

    /**
     * Terminal identification code.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 99999998
     */
    public function getTerminalId(): ?string
    {
        return $this->_getString('terminalId');
    }

    /**
     * Terminal identification code.
     *
     * @optional
     *
     * @return $this
     *
     * @example 99999998
     */
    public function setTerminalId(?string $value): self
    {
        return $value === null ? $this->_unset('terminalId') : $this->_set('terminalId', $value);
    }

    /**
     * Service enablement. Possible values:
     * - Y
     * - N
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example Y
     */
    public function getEnabled(): ?string
    {
        return $this->_getString('enabled');
    }

    /**
     * Service enablement. Possible values:
     * - Y
     * - N
     *
     * @optional
     *
     * @return $this
     *
     * @example Y
     */
    public function setEnabled(?string $value): self
    {
        return $value === null ? $this->_unset('enabled') : $this->_set('enabled', $value);
    }

    /**
     * The unique identifier of the terms and conditions accepted by the user.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 48f4c8a1-b6ef-4d54-8440-096c76308b84
     */
    public function getServiceTecId(): ?string
    {
        return $this->_getString('serviceTecId');
    }

    /**
     * The unique identifier of the terms and conditions accepted by the user.
     *
     * @optional
     *
     * @return $this
     *
     * @example 48f4c8a1-b6ef-4d54-8440-096c76308b84
     */
    public function setServiceTecId(?string $value): self
    {
        return $value === null ? $this->_unset('serviceTecId') : $this->_set('serviceTecId', $value);
    }
}