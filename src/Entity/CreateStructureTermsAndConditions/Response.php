<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\CreateStructureTermsAndConditions;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/post-structure_conditions
 */
class Response extends Entity
{
    /**
     * Unique identifier of terms and conditions of the structure.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example aeca2ac3-1d03-4f17-855b-19767f9c4586
     */
    public function getStructureConditionId(): ?string
    {
        return $this->_getString('structureConditionId');
    }

    /**
     * Unique identifier of terms and conditions of the structure.
     *
     * @optional
     *
     * @return $this
     *
     * @example aeca2ac3-1d03-4f17-855b-19767f9c4586
     */
    public function setStructureConditionId(?string $value): self
    {
        return $value === null ? $this->_unset('structureConditionId') : $this->_set('structureConditionId', $value);
    }
}
