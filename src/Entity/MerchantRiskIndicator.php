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
 * @see https://developer.nexi.it/en/api/get-build-state#tab_response
 * @see https://developer.nexi.it/en/api/get-operations#tab_response
 * @see https://developer.nexi.it/en/api/get-operations-operationId#tab_response
 * @see https://developer.nexi.it/en/api/get-orders#tab_response
 * @see https://developer.nexi.it/en/api/get-orders-orderId#tab_response
 * @see https://developer.nexi.it/en/api/get-reservations#tab_response
 * @see https://developer.nexi.it/en/api/get-reservations-reservationId#tab_response
 * @see https://developer.nexi.it/en/api/notifica#tab_body
 * @see https://developer.nexi.it/en/api/post-build-cancel#tab_response
 * @see https://developer.nexi.it/en/api/post-build-finalize-payment#tab_response
 * @see https://developer.nexi.it/en/api/post-delay_charges#tab_response
 * @see https://developer.nexi.it/en/api/post-incrementals#tab_response
 * @see https://developer.nexi.it/en/api/post-no_shows#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-2steps-init#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-2steps-init#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-2steps-payment#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-2steps-payment#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-3steps-init#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-3steps-init#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-3steps-payment#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-3steps-payment#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-3steps-validation#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-build#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-card_verification#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-card_verification#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-hpp#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-mit#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-mit#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-moto#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-moto#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-paybylink#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-virtual_card#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-virtual_card#tab_response
 * @see https://developer.nexi.it/en/api/post-reservations#tab_body
 */
class MerchantRiskIndicator extends Entity
{
    /**
     * In case of purchase of virtual/digital products: email address to which the product is sent.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example john.doe@email.com
     */
    public function getDeliveryEmail(): ?string
    {
        return $this->_getString('deliveryEmail');
    }

    /**
     * In case of purchase of virtual/digital products: email address to which the product is sent.
     *
     * @optional
     *
     * @return $this
     *
     * @example john.doe@email.com
     */
    public function setDeliveryEmail(?string $value): self
    {
        return $value === null ? $this->_unset('deliveryEmail') : $this->_set('deliveryEmail', $value);
    }

    /**
     * Indicator on the delivery period of the goods:
     * 01 = Immediate Delivery (virtual/digital products).
     * 02 = Same day delivery.
     * 03 = Night delivery.
     * 04 = Delivery in two or more days
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getDeliveryTimeframe(): ?string
    {
        return $this->_getString('deliveryTimeframe');
    }

    /**
     * Indicator on the delivery period of the goods:
     * 01 = Immediate Delivery (virtual/digital products).
     * 02 = Same day delivery.
     * 03 = Night delivery.
     * 04 = Delivery in two or more days
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setDeliveryTimeframe(?string $value): self
    {
        return $value === null ? $this->_unset('deliveryTimeframe') : $this->_set('deliveryTimeframe', $value);
    }

    /**
     * Object containing information relating to the amount of gift cards or vouchers.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getGiftCardAmount(): ?GiftCardAmount
    {
        return $this->_getEntity('giftCardAmount', GiftCardAmount::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\MerchantRiskIndicator::getGiftCardAmount()
     */
    public function getOrCreateGiftCardAmount(): GiftCardAmount
    {
        $result = $this->getGiftCardAmount();
        if ($result === null) {
            $this->setGiftCardAmount($result = new GiftCardAmount());
        }

        return $result;
    }

    /**
     * Object containing information relating to the amount of gift cards or vouchers.
     *
     * @optional
     *
     * @return $this
     */
    public function setGiftCardAmount(?GiftCardAmount $value): self
    {
        return $value === null ? $this->_unset('giftCardAmount') : $this->_set('giftCardAmount', $value);
    }

    /**
     * Total number of individual prepaid or gift cards/codes purchased.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2
     */
    public function getGiftCardCount(): ?int
    {
        return $this->_getInt('giftCardCount');
    }

    /**
     * Total number of individual prepaid or gift cards/codes purchased.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2
     */
    public function setGiftCardCount(?int $value): self
    {
        return $value === null ? $this->_unset('giftCardCount') : $this->_set('giftCardCount', $value);
    }

    /**
     * For a pre-ordered purchase, the expected date that the merchandise will be available.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2019-02-11
     */
    public function getPreOrderDate(): ?string
    {
        return $this->_getString('preOrderDate');
    }

    /**
     * For a pre-ordered purchase, the expected date that the merchandise will be available.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2019-02-11
     */
    public function setPreOrderDate(?string $value): self
    {
        return $value === null ? $this->_unset('preOrderDate') : $this->_set('preOrderDate', $value);
    }

    /**
     * Indicates whether buyer is placing an order for merchandise with a future availability:
     * 01 = Goods available.
     * 02 = Future availability.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getPreOrderPurchaseIndicator(): ?string
    {
        return $this->_getString('preOrderPurchaseIndicator');
    }

    /**
     * Indicates whether buyer is placing an order for merchandise with a future availability:
     * 01 = Goods available.
     * 02 = Future availability.
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setPreOrderPurchaseIndicator(?string $value): self
    {
        return $value === null ? $this->_unset('preOrderPurchaseIndicator') : $this->_set('preOrderPurchaseIndicator', $value);
    }

    /**
     * Indicates whether the cardholder is reordering previously purchased merchandise:
     * 01 = First order.
     * 02 = Goods already purchased previously.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getReorderItemsIndicator(): ?string
    {
        return $this->_getString('reorderItemsIndicator');
    }

    /**
     * Indicates whether the cardholder is reordering previously purchased merchandise:
     * 01 = First order.
     * 02 = Goods already purchased previously.
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setReorderItemsIndicator(?string $value): self
    {
        return $value === null ? $this->_unset('reorderItemsIndicator') : $this->_set('reorderItemsIndicator', $value);
    }

    /**
     * Indicator on the type of delivery:
     * 01 = Shipping to the billing address.
     * 02 = Shipping to another address verified by the merchant.
     * 03 = Delivery to a different address than the billing.
     * 04 = Shipment or collection to the store (the address of the store must be indicated in the "destinationAddress" object).
     * 05 = Virtual/digital goods, including online services, electronic gift certificates, recovery codes.
     * 06 = Travel and event tickets (not sent).
     * 07 = Other: for example games, digital services not sent, electronic media subscriptions
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getShipIndicator(): ?string
    {
        return $this->_getString('shipIndicator');
    }

    /**
     * Indicator on the type of delivery:
     * 01 = Shipping to the billing address.
     * 02 = Shipping to another address verified by the merchant.
     * 03 = Delivery to a different address than the billing.
     * 04 = Shipment or collection to the store (the address of the store must be indicated in the "destinationAddress" object).
     * 05 = Virtual/digital goods, including online services, electronic gift certificates, recovery codes.
     * 06 = Travel and event tickets (not sent).
     * 07 = Other: for example games, digital services not sent, electronic media subscriptions
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setShipIndicator(?string $value): self
    {
        return $value === null ? $this->_unset('shipIndicator') : $this->_set('shipIndicator', $value);
    }
}
