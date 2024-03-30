<?php

declare(strict_types=1);

namespace MLocati\Nexi\Entity\CreateOrderForPayByLink;

use MLocati\Nexi\Entity;

/*
 * WARNING: DO NOT EDIT THIS FILE
 * It has been generated automaticlly from a template.
 * Edit the template instead.
 */

/**
 * @see https://developer.nexi.it/en/api/post-orders-paybylink
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
     * @see \MLocati\Nexi\Entity\CreateOrderForPayByLink\Request::getOrder()
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
     * Object containing the payment details.
     *
     * @required
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getPaymentSession(): ?\MLocati\Nexi\Entity\PaymentSession
    {
        return $this->_getEntity('paymentSession', \MLocati\Nexi\Entity\PaymentSession::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CreateOrderForPayByLink\Request::getPaymentSession()
     */
    public function getOrCreatePaymentSession(): \MLocati\Nexi\Entity\PaymentSession
    {
        $result = $this->getPaymentSession();
        if ($result === null) {
            $this->setPaymentSession($result = new \MLocati\Nexi\Entity\PaymentSession());
        }

        return $result;
    }

    /**
     * Object containing the payment details.
     *
     * @required
     *
     * @return $this
     */
    public function setPaymentSession(\MLocati\Nexi\Entity\PaymentSession $value): self
    {
        return $this->_set('paymentSession', $value);
    }

    /**
     * Expiration date. Maximum 90 days after the link creation.
     *
     * @required
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2022-09-01
     */
    public function getExpirationDate(): ?string
    {
        return $this->_getString('expirationDate');
    }

    /**
     * Expiration date. Maximum 90 days after the link creation.
     *
     * @required
     *
     * @return $this
     *
     * @example 2022-09-01
     */
    public function setExpirationDate(string $value): self
    {
        return $this->_set('expirationDate', $value);
    }
}
