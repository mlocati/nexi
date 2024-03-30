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
class CardHolderAcctInfo extends Entity
{
    /**
     * Date of activation of the account on the merchant's website.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2019-02-11
     */
    public function getChAccDate(): ?string
    {
        return $this->_getString('chAccDate');
    }

    /**
     * Date of activation of the account on the merchant's website.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2019-02-11
     */
    public function setChAccDate(?string $value): self
    {
        return $value === null ? $this->_unset('chAccDate') : $this->_set('chAccDate', $value);
    }

    /**
     * Account age indicator on the merchant site:
     * 01 = No account
     * 02 = Created during this transaction
     * 03 = Created in the last 30 days
     * 04 = Created between 30 and 60 days ago
     * 05 = Created before 60 days ago
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getChAccAgeIndicator(): ?string
    {
        return $this->_getString('chAccAgeIndicator');
    }

    /**
     * Account age indicator on the merchant site:
     * 01 = No account
     * 02 = Created during this transaction
     * 03 = Created in the last 30 days
     * 04 = Created between 30 and 60 days ago
     * 05 = Created before 60 days ago
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setChAccAgeIndicator(?string $value): self
    {
        return $value === null ? $this->_unset('chAccAgeIndicator') : $this->_set('chAccAgeIndicator', $value);
    }

    /**
     * Date of the last variation of the account on the merchant's website, including Billing or Shipping address, new payment account, or new user(s) added.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2019-02-11
     */
    public function getChAccChangeDate(): ?string
    {
        return $this->_getString('chAccChangeDate');
    }

    /**
     * Date of the last variation of the account on the merchant's website, including Billing or Shipping address, new payment account, or new user(s) added.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2019-02-11
     */
    public function setChAccChangeDate(?string $value): self
    {
        return $value === null ? $this->_unset('chAccChangeDate') : $this->_set('chAccChangeDate', $value);
    }

    /**
     * Elapsed time since the last change to the buyer's account information on the merchant site, including Billing or Shipping address, new payment account, or new user(s) added.
     * 01 = Created during this transaction
     * 02 = Created in the last 30 days
     * 03 = Created between 30 and 60 days ago
     * 04 = Created before 60 days ago
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getChAccChangeIndicator(): ?string
    {
        return $this->_getString('chAccChangeIndicator');
    }

    /**
     * Elapsed time since the last change to the buyer's account information on the merchant site, including Billing or Shipping address, new payment account, or new user(s) added.
     * 01 = Created during this transaction
     * 02 = Created in the last 30 days
     * 03 = Created between 30 and 60 days ago
     * 04 = Created before 60 days ago
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setChAccChangeIndicator(?string $value): self
    {
        return $value === null ? $this->_unset('chAccChangeIndicator') : $this->_set('chAccChangeIndicator', $value);
    }

    /**
     * Date of last account password change (including password reset).
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2019-02-11
     */
    public function getChAccPwChangeDate(): ?string
    {
        return $this->_getString('chAccPwChangeDate');
    }

    /**
     * Date of last account password change (including password reset).
     *
     * @optional
     *
     * @return $this
     *
     * @example 2019-02-11
     */
    public function setChAccPwChangeDate(?string $value): self
    {
        return $value === null ? $this->_unset('chAccPwChangeDate') : $this->_set('chAccPwChangeDate', $value);
    }

    /**
     * Time elapsed since the buyer's account performed a password change or account recovery:
     * 01 = No account
     * 02 = Created during this transaction
     * 03 = In the last 30 days
     * 04 = Between 30 and 60 days ago
     * 05 = Before 60 days ago
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getChAccPwChangeIndicator(): ?string
    {
        return $this->_getString('chAccPwChangeIndicator');
    }

    /**
     * Time elapsed since the buyer's account performed a password change or account recovery:
     * 01 = No account
     * 02 = Created during this transaction
     * 03 = In the last 30 days
     * 04 = Between 30 and 60 days ago
     * 05 = Before 60 days ago
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setChAccPwChangeIndicator(?string $value): self
    {
        return $value === null ? $this->_unset('chAccPwChangeIndicator') : $this->_set('chAccPwChangeIndicator', $value);
    }

    /**
     * Number of purchases of this account in the last 6 months.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 0
     */
    public function getNbPurchaseAccount(): ?int
    {
        return $this->_getInt('nbPurchaseAccount');
    }

    /**
     * Number of purchases of this account in the last 6 months.
     *
     * @optional
     *
     * @return $this
     *
     * @example 0
     */
    public function setNbPurchaseAccount(?int $value): self
    {
        return $value === null ? $this->_unset('nbPurchaseAccount') : $this->_set('nbPurchaseAccount', $value);
    }

    /**
     * Date of last use of this delivery address.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2019-02-11
     */
    public function getDestinationAddressUsageDate(): ?string
    {
        return $this->_getString('destinationAddressUsageDate');
    }

    /**
     * Date of last use of this delivery address.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2019-02-11
     */
    public function setDestinationAddressUsageDate(?string $value): self
    {
        return $value === null ? $this->_unset('destinationAddressUsageDate') : $this->_set('destinationAddressUsageDate', $value);
    }

    /**
     * Indicates when the shipping address used for this transaction was used for the first time:
     * 01 = Created during this transaction
     * 02 = Created in the last 30 days
     * 03 = Created between 30 and 60 days ago
     * 04 = Created before 60 days ago
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getDestinationAddressUsageIndicator(): ?string
    {
        return $this->_getString('destinationAddressUsageIndicator');
    }

    /**
     * Indicates when the shipping address used for this transaction was used for the first time:
     * 01 = Created during this transaction
     * 02 = Created in the last 30 days
     * 03 = Created between 30 and 60 days ago
     * 04 = Created before 60 days ago
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setDestinationAddressUsageIndicator(?string $value): self
    {
        return $value === null ? $this->_unset('destinationAddressUsageIndicator') : $this->_set('destinationAddressUsageIndicator', $value);
    }

    /**
     * Indicates if the name associated with the account matches the name listed for shipping:
     * 01 = Account name identical to the shipping address name.
     * 02 = Different account name from the shipping address name
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getDestinationNameIndicator(): ?string
    {
        return $this->_getString('destinationNameIndicator');
    }

    /**
     * Indicates if the name associated with the account matches the name listed for shipping:
     * 01 = Account name identical to the shipping address name.
     * 02 = Different account name from the shipping address name
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setDestinationNameIndicator(?string $value): self
    {
        return $value === null ? $this->_unset('destinationNameIndicator') : $this->_set('destinationNameIndicator', $value);
    }

    /**
     * Number of transactions (successful and abandoned) for this account in the previous 24 hours.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 0
     */
    public function getTxnActivityDay(): ?int
    {
        return $this->_getInt('txnActivityDay');
    }

    /**
     * Number of transactions (successful and abandoned) for this account in the previous 24 hours.
     *
     * @optional
     *
     * @return $this
     *
     * @example 0
     */
    public function setTxnActivityDay(?int $value): self
    {
        return $value === null ? $this->_unset('txnActivityDay') : $this->_set('txnActivityDay', $value);
    }

    /**
     * Number of transactions (successful and abandoned) for this account in the previous year.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 0
     */
    public function getTxnActivityYear(): ?int
    {
        return $this->_getInt('txnActivityYear');
    }

    /**
     * Number of transactions (successful and abandoned) for this account in the previous year.
     *
     * @optional
     *
     * @return $this
     *
     * @example 0
     */
    public function setTxnActivityYear(?int $value): self
    {
        return $value === null ? $this->_unset('txnActivityYear') : $this->_set('txnActivityYear', $value);
    }

    /**
     * Number of attempts to add a new card in the last 24 hours.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 0
     */
    public function getProvisionAttemptsDay(): ?int
    {
        return $this->_getInt('provisionAttemptsDay');
    }

    /**
     * Number of attempts to add a new card in the last 24 hours.
     *
     * @optional
     *
     * @return $this
     *
     * @example 0
     */
    public function setProvisionAttemptsDay(?int $value): self
    {
        return $value === null ? $this->_unset('provisionAttemptsDay') : $this->_set('provisionAttemptsDay', $value);
    }

    /**
     * Indicates whether the merchant has detected suspicious activity (including previous fraud) on the buyer's account:
     * 01 = No suspicious activity verified.
     * 02 = Suspicious activity detected
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 01
     */
    public function getSuspiciousAccActivity(): ?string
    {
        return $this->_getString('suspiciousAccActivity');
    }

    /**
     * Indicates whether the merchant has detected suspicious activity (including previous fraud) on the buyer's account:
     * 01 = No suspicious activity verified.
     * 02 = Suspicious activity detected
     *
     * @optional
     *
     * @return $this
     *
     * @example 01
     */
    public function setSuspiciousAccActivity(?string $value): self
    {
        return $value === null ? $this->_unset('suspiciousAccActivity') : $this->_set('suspiciousAccActivity', $value);
    }

    /**
     * Payment account activation date.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2019-02-11
     */
    public function getPaymentAccAgeDate(): ?string
    {
        return $this->_getString('paymentAccAgeDate');
    }

    /**
     * Payment account activation date.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2019-02-11
     */
    public function setPaymentAccAgeDate(?string $value): self
    {
        return $value === null ? $this->_unset('paymentAccAgeDate') : $this->_set('paymentAccAgeDate', $value);
    }

    /**
     * Indicates when the buyer has entered the Payment account on the merchant's site:
     * 01 = No account
     * 02 = created during this transaction
     * 03 = Created in the last 30 days
     * 04 = Created between 30 and 60 days ago
     * 05 = Created before 60 days ago
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 0
     */
    public function getPaymentAccIndicator(): ?string
    {
        return $this->_getString('paymentAccIndicator');
    }

    /**
     * Indicates when the buyer has entered the Payment account on the merchant's site:
     * 01 = No account
     * 02 = created during this transaction
     * 03 = Created in the last 30 days
     * 04 = Created between 30 and 60 days ago
     * 05 = Created before 60 days ago
     *
     * @optional
     *
     * @return $this
     *
     * @example 0
     */
    public function setPaymentAccIndicator(?string $value): self
    {
        return $value === null ? $this->_unset('paymentAccIndicator') : $this->_set('paymentAccIndicator', $value);
    }
}