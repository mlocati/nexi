<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\CreateReservation;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/post-reservations
 */
class Request extends Entity
{
    /**
     * Object containing the reservation details.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getReservation(): ?\MLocati\Nexi\Entity\Reservation
    {
        return $this->_getEntity('reservation', \MLocati\Nexi\Entity\Reservation::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CreateReservation\Request::getReservation()
     */
    public function getOrCreateReservation(): \MLocati\Nexi\Entity\Reservation
    {
        $result = $this->getReservation();
        if ($result === null) {
            $this->setReservation($result = new \MLocati\Nexi\Entity\Reservation());
        }

        return $result;
    }

    /**
     * Object containing the reservation details.
     *
     * @optional
     *
     * @return $this
     */
    public function setReservation(?\MLocati\Nexi\Entity\Reservation $value): self
    {
        return $value === null ? $this->_unset('reservation') : $this->_set('reservation', $value);
    }
}
