<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\CreateOrderForMotoPayment;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/post-orders-moto
 */
class Request extends Entity
{
    /**
     * Object containing the detail of the order.
     *
     * @required
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getOrder(): ?\MLocati\Nexi\Entity\Order
    {
        return $this->_getEntity('order', \MLocati\Nexi\Entity\Order::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CreateOrderForMotoPayment\Request::getOrder()
     */
    public function getOrCreateOrder(): \MLocati\Nexi\Entity\Order
    {
        $result = $this->getOrder();
        if ($result === null) {
            $this->setOrder($result = new \MLocati\Nexi\Entity\Order());
        }

        return $result;
    }

    /**
     * Object containing the detail of the order.
     *
     * @required
     *
     * @return $this
     */
    public function setOrder(\MLocati\Nexi\Entity\Order $value): self
    {
        return $this->_set('order', $value);
    }

    /**
     * Object containing the details of the payment card.
     *
     * @required
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getCard(): ?\MLocati\Nexi\Entity\Card
    {
        return $this->_getEntity('card', \MLocati\Nexi\Entity\Card::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CreateOrderForMotoPayment\Request::getCard()
     */
    public function getOrCreateCard(): \MLocati\Nexi\Entity\Card
    {
        $result = $this->getCard();
        if ($result === null) {
            $this->setCard($result = new \MLocati\Nexi\Entity\Card());
        }

        return $result;
    }

    /**
     * Object containing the details of the payment card.
     *
     * @required
     *
     * @return $this
     */
    public function setCard(\MLocati\Nexi\Entity\Card $value): self
    {
        return $this->_set('card', $value);
    }

    /**
     * Overwrites the default confirmation method of the terminal, for card payments only:
     * * IMPLICIT - automatic confirmation
     * * EXPLICIT - authorization only
     * Default value depends on the terminal configuration.
     * 1. Terminal set to EXPLICIT:
     * a. if the captureType is EXPLICIT the capture will be EXPLICIT
     * b. if the captureType is null the capture will be EXPLICIT
     * c. if the captureType is IMPLICIT the capture will be IMPLICIT
     * 2. Terminal set to IMPLICIT:
     * a. if the captureType is EXPLICIT the capture will be an error
     * b. if the captureType is null the capture will be IMPLICIT
     * c. if the captureType is IMPLICIT the capture will be IMPLICIT
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example EXPLICIT
     */
    public function getCaptureType(): ?string
    {
        return $this->_getString('captureType');
    }

    /**
     * Overwrites the default confirmation method of the terminal, for card payments only:
     * * IMPLICIT - automatic confirmation
     * * EXPLICIT - authorization only
     * Default value depends on the terminal configuration.
     * 1. Terminal set to EXPLICIT:
     * a. if the captureType is EXPLICIT the capture will be EXPLICIT
     * b. if the captureType is null the capture will be EXPLICIT
     * c. if the captureType is IMPLICIT the capture will be IMPLICIT
     * 2. Terminal set to IMPLICIT:
     * a. if the captureType is EXPLICIT the capture will be an error
     * b. if the captureType is null the capture will be IMPLICIT
     * c. if the captureType is IMPLICIT the capture will be IMPLICIT
     *
     * @optional
     *
     * @return $this
     *
     * @example EXPLICIT
     */
    public function setCaptureType(?string $value): self
    {
        return $value === null ? $this->_unset('captureType') : $this->_set('captureType', $value);
    }
}