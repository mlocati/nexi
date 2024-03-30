<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\FindReservationById;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/get-reservations-reservationId
 */
class Response extends Entity
{
    /**
     * Object containing the details of the reservation status.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getReservationStatus(): ?\MLocati\Nexi\Entity\ReservationStatus
    {
        return $this->_getEntity('reservationStatus', \MLocati\Nexi\Entity\ReservationStatus::class);
    }

    /**
     * Object containing the details of the reservation status.
     *
     * @optional
     *
     * @return $this
     */
    public function setReservationStatus(?\MLocati\Nexi\Entity\ReservationStatus $value): self
    {
        return $value === null ? $this->_unset('reservationStatus') : $this->_set('reservationStatus', $value);
    }

    /**
     * Array containing the details of the operations performed.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\Entity\Operation[]|null
     */
    public function getOperations(): ?array
    {
        return $this->_getEntityArray('operations', \MLocati\Nexi\Entity\Operation::class);
    }

    /**
     * Array containing the details of the operations performed.
     *
     * @param \MLocati\Nexi\Entity\Operation[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setOperations(?array $value): self
    {
        return $value === null ? $this->_unset('operations') : $this->_setEntityArray('operations', \MLocati\Nexi\Entity\Operation::class, $value);
    }

    /**
     * Array containing the payment links list.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\Entity\PaymentLink[]|null
     */
    public function getPaymentLinks(): ?array
    {
        return $this->_getEntityArray('paymentLinks', \MLocati\Nexi\Entity\PaymentLink::class);
    }

    /**
     * Array containing the payment links list.
     *
     * @param \MLocati\Nexi\Entity\PaymentLink[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setPaymentLinks(?array $value): self
    {
        return $value === null ? $this->_unset('paymentLinks') : $this->_setEntityArray('paymentLinks', \MLocati\Nexi\Entity\PaymentLink::class, $value);
    }
}