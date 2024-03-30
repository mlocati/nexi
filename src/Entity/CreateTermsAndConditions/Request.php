<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\CreateTermsAndConditions;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/post-termsAndConditions
 */
class Request extends Entity
{
    /**
     * Free label to let the merchant identify the Terms and Conditions version for audit purposes.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example Grand Hotel Mississipi selling conditions v01
     */
    public function getName(): ?string
    {
        return $this->_getString('name');
    }

    /**
     * Free label to let the merchant identify the Terms and Conditions version for audit purposes.
     *
     * @optional
     *
     * @return $this
     *
     * @example Grand Hotel Mississipi selling conditions v01
     */
    public function setName(?string $value): self
    {
        return $value === null ? $this->_unset('name') : $this->_set('name', $value);
    }

    /**
     * Array of Terms and Conditions in multiple languages.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\Entity\TermsAndConditions[]|null
     */
    public function getTermsAndConditions(): ?array
    {
        return $this->_getEntityArray('termsAndConditions', \MLocati\Nexi\Entity\TermsAndConditions::class);
    }

    /**
     * Array of Terms and Conditions in multiple languages.
     *
     * @param \MLocati\Nexi\Entity\TermsAndConditions[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setTermsAndConditions(?array $value): self
    {
        return $value === null ? $this->_unset('termsAndConditions') : $this->_setEntityArray('termsAndConditions', \MLocati\Nexi\Entity\TermsAndConditions::class, $value);
    }
}
