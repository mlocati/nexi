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
 * @see https://developer.nexi.it/en/api/post-orders-2steps-payment#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-3steps-payment#tab_body
 */
class ThreeDSAuthData extends Entity
{
    /**
     * 3DS authentication result. Provided in the 2-steps flow when the validation phase is not used.
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
     * 3DS authentication result. Provided in the 2-steps flow when the validation phase is not used.
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

    /**
     * Completed for the 3-steps flow, obtained from the validation phase.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example AAIBBjhkYQAAAAAKl4FHdAAAAAA=
     */
    public function getAuthenticationValue(): ?string
    {
        return $this->_getString('authenticationValue');
    }

    /**
     * Completed for the 3-steps flow, obtained from the validation phase.
     *
     * @optional
     *
     * @return $this
     *
     * @example AAIBBjhkYQAAAAAKl4FHdAAAAAA=
     */
    public function setAuthenticationValue(?string $value): self
    {
        return $value === null ? $this->_unset('authenticationValue') : $this->_set('authenticationValue', $value);
    }

    /**
     * Completed for the 3-steps flow, obtained from the validation phase.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 05
     */
    public function getEci(): ?string
    {
        return $this->_getString('eci');
    }

    /**
     * Completed for the 3-steps flow, obtained from the validation phase.
     *
     * @optional
     *
     * @return $this
     *
     * @example 05
     */
    public function setEci(?string $value): self
    {
        return $value === null ? $this->_unset('eci') : $this->_set('eci', $value);
    }

    /**
     * Completed for the 3-steps flow, obtained from the validation phase.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example RExDQXMtS05EJTt6VlBNRnxdOkY=
     */
    public function getXid(): ?string
    {
        return $this->_getString('xid');
    }

    /**
     * Completed for the 3-steps flow, obtained from the validation phase.
     *
     * @optional
     *
     * @return $this
     *
     * @example RExDQXMtS05EJTt6VlBNRnxdOkY=
     */
    public function setXid(?string $value): self
    {
        return $value === null ? $this->_unset('xid') : $this->_set('xid', $value);
    }
}