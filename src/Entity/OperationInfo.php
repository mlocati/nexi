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
 * @see https://developer.nexi.it/en/api/post-operations-operationId-cancels
 * @see https://developer.nexi.it/en/api/post-operations-operationId-captures
 * @see https://developer.nexi.it/en/api/post-operations-operationId-refunds
 */
class OperationInfo extends Entity
{
    /**
     * Operation ID.
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
     * Operation ID.
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
     * Post operation time.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2022-09-01T01:20:00.001Z
     */
    public function getOperationTime(): ?string
    {
        return $this->_getString('operationTime');
    }

    /**
     * Post operation time.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2022-09-01T01:20:00.001Z
     */
    public function setOperationTime(?string $value): self
    {
        return $value === null ? $this->_unset('operationTime') : $this->_set('operationTime', $value);
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Entity::getRequiredFields()
     */
    protected function getRequiredFields(): array
    {
        return [
        ];
    }
}
