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
class CustomerInfo extends Entity
{
    /**
     * Name and surname of the cardholder.
     *
     * @required in the request body of the createOrderForMotoPayment method
     * @optional in other cases
     * Maximum length: 255
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example Mauro Morandi
     */
    public function getCardHolderName(): ?string
    {
        return $this->_getString('cardHolderName');
    }

    /**
     * Name and surname of the cardholder.
     *
     * @required in the request body of the createOrderForMotoPayment method
     * @optional in other cases
     * Maximum length: 255
     *
     * @return $this
     *
     * @example Mauro Morandi
     */
    public function setCardHolderName(?string $value): self
    {
        return $value === null ? $this->_unset('cardHolderName') : $this->_set('cardHolderName', $value);
    }

    /**
     * Email of the cardholder.
     *
     * @optional
     * Maximum length: 255
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example mauro.morandi@nexi.it
     */
    public function getCardHolderEmail(): ?string
    {
        return $this->_getString('cardHolderEmail');
    }

    /**
     * Email of the cardholder.
     *
     * @optional
     * Maximum length: 255
     *
     * @return $this
     *
     * @example mauro.morandi@nexi.it
     */
    public function setCardHolderEmail(?string $value): self
    {
        return $value === null ? $this->_unset('cardHolderEmail') : $this->_set('cardHolderEmail', $value);
    }

    /**
     * Object containing the detail of the customer's address.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getBillingAddress(): ?BillingAddress
    {
        return $this->_getEntity('billingAddress', BillingAddress::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CustomerInfo::getBillingAddress()
     */
    public function getOrCreateBillingAddress(): BillingAddress
    {
        $result = $this->getBillingAddress();
        if ($result === null) {
            $this->setBillingAddress($result = new BillingAddress());
        }

        return $result;
    }

    /**
     * Object containing the detail of the customer's address.
     *
     * @optional
     *
     * @return $this
     */
    public function setBillingAddress(?BillingAddress $value): self
    {
        return $value === null ? $this->_unset('billingAddress') : $this->_set('billingAddress', $value);
    }

    /**
     * Object containing the detail of the customer's address.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getShippingAddress(): ?BillingAddress
    {
        return $this->_getEntity('shippingAddress', BillingAddress::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CustomerInfo::getShippingAddress()
     */
    public function getOrCreateShippingAddress(): BillingAddress
    {
        $result = $this->getShippingAddress();
        if ($result === null) {
            $this->setShippingAddress($result = new BillingAddress());
        }

        return $result;
    }

    /**
     * Object containing the detail of the customer's address.
     *
     * @optional
     *
     * @return $this
     */
    public function setShippingAddress(?BillingAddress $value): self
    {
        return $value === null ? $this->_unset('shippingAddress') : $this->_set('shippingAddress', $value);
    }

    /**
     * Prefix of the mobile phone.
     *
     * @optional
     * Maximum length: 4
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example +39
     */
    public function getMobilePhoneCountryCode(): ?string
    {
        return $this->_getString('mobilePhoneCountryCode');
    }

    /**
     * Prefix of the mobile phone.
     *
     * @optional
     * Maximum length: 4
     *
     * @return $this
     *
     * @example +39
     */
    public function setMobilePhoneCountryCode(?string $value): self
    {
        return $value === null ? $this->_unset('mobilePhoneCountryCode') : $this->_set('mobilePhoneCountryCode', $value);
    }

    /**
     * Mobile phone.
     *
     * @optional
     * Maximum length: 15
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 3280987654
     */
    public function getMobilePhone(): ?string
    {
        return $this->_getString('mobilePhone');
    }

    /**
     * Mobile phone.
     *
     * @optional
     * Maximum length: 15
     *
     * @return $this
     *
     * @example 3280987654
     */
    public function setMobilePhone(?string $value): self
    {
        return $value === null ? $this->_unset('mobilePhone') : $this->_set('mobilePhone', $value);
    }

    /**
     * Home phone number provided by the Cardholder.
     *
     * @optional
     * Maximum length: 18
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example +391231234567
     */
    public function getHomePhone(): ?string
    {
        return $this->_getString('homePhone');
    }

    /**
     * Home phone number provided by the Cardholder.
     *
     * @optional
     * Maximum length: 18
     *
     * @return $this
     *
     * @example +391231234567
     */
    public function setHomePhone(?string $value): self
    {
        return $value === null ? $this->_unset('homePhone') : $this->_set('homePhone', $value);
    }

    /**
     * Work phone number provided by the Cardholder.
     *
     * @optional
     * Maximum length: 18
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 391231234567
     */
    public function getWorkPhone(): ?string
    {
        return $this->_getString('workPhone');
    }

    /**
     * Work phone number provided by the Cardholder.
     *
     * @optional
     * Maximum length: 18
     *
     * @return $this
     *
     * @example 391231234567
     */
    public function setWorkPhone(?string $value): self
    {
        return $value === null ? $this->_unset('workPhone') : $this->_set('workPhone', $value);
    }

    /**
     * Object containing information about the buyer's account.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getCardHolderAcctInfo(): ?CardHolderAcctInfo
    {
        return $this->_getEntity('cardHolderAcctInfo', CardHolderAcctInfo::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CustomerInfo::getCardHolderAcctInfo()
     */
    public function getOrCreateCardHolderAcctInfo(): CardHolderAcctInfo
    {
        $result = $this->getCardHolderAcctInfo();
        if ($result === null) {
            $this->setCardHolderAcctInfo($result = new CardHolderAcctInfo());
        }

        return $result;
    }

    /**
     * Object containing information about the buyer's account.
     *
     * @optional
     *
     * @return $this
     */
    public function setCardHolderAcctInfo(?CardHolderAcctInfo $value): self
    {
        return $value === null ? $this->_unset('cardHolderAcctInfo') : $this->_set('cardHolderAcctInfo', $value);
    }

    /**
     * Object containing information relating to the purchase made.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getMerchantRiskIndicator(): ?MerchantRiskIndicator
    {
        return $this->_getEntity('merchantRiskIndicator', MerchantRiskIndicator::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\CustomerInfo::getMerchantRiskIndicator()
     */
    public function getOrCreateMerchantRiskIndicator(): MerchantRiskIndicator
    {
        $result = $this->getMerchantRiskIndicator();
        if ($result === null) {
            $this->setMerchantRiskIndicator($result = new MerchantRiskIndicator());
        }

        return $result;
    }

    /**
     * Object containing information relating to the purchase made.
     *
     * @optional
     *
     * @return $this
     */
    public function setMerchantRiskIndicator(?MerchantRiskIndicator $value): self
    {
        return $value === null ? $this->_unset('merchantRiskIndicator') : $this->_set('merchantRiskIndicator', $value);
    }
}
