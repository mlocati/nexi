<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\GetOperationActions;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/get-operations-operationId-actions
 */
class Response extends Entity
{
    /**
     * Array of objects containing the details of the actions.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return object[]|array[]|null
     */
    public function getActions(): ?array
    {
        return $this->_getCustomObjectArray('actions');
    }

    /**
     * Array of objects containing the details of the actions.
     *
     * @param object[]|array[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setActions(?array $value): self
    {
        return $value === null ? $this->_unset('actions') : $this->_setCustomObjectArray('actions', $value);
    }
}