<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\CreateVirtualCartOrder;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/post-orders-virtual_card
 */
class Request extends Entity
{
    /**
     * Object containing the detail of the order.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getOrder(): ?\MLocati\Nexi\Entity\Order
    {
        return $this->_getEntity('order', \MLocati\Nexi\Entity\Order::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CreateVirtualCartOrder\Request::getOrder()
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
     * @optional
     *
     * @return $this
     */
    public function setOrder(?\MLocati\Nexi\Entity\Order $value): self
    {
        return $value === null ? $this->_unset('order') : $this->_set('order', $value);
    }

    /**
     * Object containing the details of the payment card.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getCard(): ?\MLocati\Nexi\Entity\Card
    {
        return $this->_getEntity('card', \MLocati\Nexi\Entity\Card::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CreateVirtualCartOrder\Request::getCard()
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
     * @optional
     *
     * @return $this
     */
    public function setCard(?\MLocati\Nexi\Entity\Card $value): self
    {
        return $value === null ? $this->_unset('card') : $this->_set('card', $value);
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

    /**
     * Transaction amount in smallest currency unit. 50 EUR is represented as 5000 (2 decimals) 50 JPY is represented as 50 (0 decimals). Used when the amount is different by the one present on the order. The currency to consider is the one defined to the amount order.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 3545
     */
    public function getSessionAmount(): ?string
    {
        return $this->_getString('sessionAmount');
    }

    /**
     * Transaction amount in smallest currency unit. 50 EUR is represented as 5000 (2 decimals) 50 JPY is represented as 50 (0 decimals). Used when the amount is different by the one present on the order. The currency to consider is the one defined to the amount order.
     *
     * @optional
     *
     * @return $this
     *
     * @example 3545
     */
    public function setSessionAmount(?string $value): self
    {
        return $value === null ? $this->_unset('sessionAmount') : $this->_set('sessionAmount', $value);
    }
}
