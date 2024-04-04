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
 * @see https://developer.nexi.it/en/api/get-reservations#tab_response
 * @see https://developer.nexi.it/en/api/get-reservations-reservationId#tab_response
 * @see https://developer.nexi.it/en/api/post-reservations#tab_body
 */
class Reservation extends Entity
{
    /**
     * Merchant reservation id, unique in the merchant domain.
     *
     * @optional
     * Maximum length: 27
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example btid2384983
     */
    public function getReservationId(): ?string
    {
        return $this->_getString('reservationId');
    }

    /**
     * Merchant reservation id, unique in the merchant domain.
     *
     * @optional
     * Maximum length: 27
     *
     * @return $this
     *
     * @example btid2384983
     */
    public function setReservationId(?string $value): self
    {
        return $value === null ? $this->_unset('reservationId') : $this->_set('reservationId', $value);
    }

    /**
     * Possible values:
     * - ACTIVE
     * - CANCELED
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example ACTIVE
     */
    public function getStatus(): ?string
    {
        return $this->_getString('status');
    }

    /**
     * Possible values:
     * - ACTIVE
     * - CANCELED
     *
     * @optional
     *
     * @return $this
     *
     * @example ACTIVE
     */
    public function setStatus(?string $value): self
    {
        return $value === null ? $this->_unset('status') : $this->_set('status', $value);
    }

    /**
     * The timestamp related to structure creation dall'esercente.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2022-08-01
     */
    public function getCreationDate(): ?string
    {
        return $this->_getString('creationDate');
    }

    /**
     * The timestamp related to structure creation dall'esercente.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2022-08-01
     */
    public function setCreationDate(?string $value): self
    {
        return $value === null ? $this->_unset('creationDate') : $this->_set('creationDate', $value);
    }

    /**
     * Transaction amount in smallest currency unit. 50 EUR is represented as 5000 (2 decimals) 50 JPY is represented as 50 (0 decimals).
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 3545
     */
    public function getAmount(): ?string
    {
        return $this->_getString('amount');
    }

    /**
     * Transaction amount in smallest currency unit. 50 EUR is represented as 5000 (2 decimals) 50 JPY is represented as 50 (0 decimals).
     *
     * @optional
     *
     * @return $this
     *
     * @example 3545
     */
    public function setAmount(?string $value): self
    {
        return $value === null ? $this->_unset('amount') : $this->_set('amount', $value);
    }

    /**
     * Transaction currency. ISO 4217 alphabetic code.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example EUR
     */
    public function getCurrency(): ?string
    {
        return $this->_getString('currency');
    }

    /**
     * Transaction currency. ISO 4217 alphabetic code.
     *
     * @optional
     *
     * @return $this
     *
     * @example EUR
     */
    public function setCurrency(?string $value): self
    {
        return $value === null ? $this->_unset('currency') : $this->_set('currency', $value);
    }

    /**
     * Transaction amount in smallest currency unit. 50 EUR is represented as 5000 (2 decimals) 50 JPY is represented as 50 (0 decimals).
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 3500
     */
    public function getDeposit(): ?string
    {
        return $this->_getString('deposit');
    }

    /**
     * Transaction amount in smallest currency unit. 50 EUR is represented as 5000 (2 decimals) 50 JPY is represented as 50 (0 decimals).
     *
     * @optional
     *
     * @return $this
     *
     * @example 3500
     */
    public function setDeposit(?string $value): self
    {
        return $value === null ? $this->_unset('deposit') : $this->_set('deposit', $value);
    }

    /**
     * Transaction description.
     *
     * @optional
     * Maximum length: 255
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example Prenotazione camera - Cefalù
     */
    public function getDescription(): ?string
    {
        return $this->_getString('description');
    }

    /**
     * Transaction description.
     *
     * @optional
     * Maximum length: 255
     *
     * @return $this
     *
     * @example Prenotazione camera - Cefalù
     */
    public function setDescription(?string $value): self
    {
        return $value === null ? $this->_unset('description') : $this->_set('description', $value);
    }

    /**
     * Possible values:
     * - PREPAID_REFUNDABLE: reservation is paid in advace for the service that will be provided and it can be refundable.
     * - PREPAID_NOT_REFUNDABLE: reservation is paid in advace for the service that will be provided and it can not be refundable.
     * - GUARANTEED_NOSHOW: reservation, through a card verification without charge to the customer. If the customer does not show up at the property, it is possible to charge the cost of the first night of stay.
     * - GUARANTEED_PENALTY: reservation, through a card verification without charge to the customer. An automatic charge of the predetermined penalty is made in case a guest does not show up at the property.
     * - BUNDLE: booking of a package containing several services provided by the same structure, for example stay + excursion + restaurant + tourist bus.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example GUARANTEED
     */
    public function getReservationType(): ?string
    {
        return $this->_getString('reservationType');
    }

    /**
     * Possible values:
     * - PREPAID_REFUNDABLE: reservation is paid in advace for the service that will be provided and it can be refundable.
     * - PREPAID_NOT_REFUNDABLE: reservation is paid in advace for the service that will be provided and it can not be refundable.
     * - GUARANTEED_NOSHOW: reservation, through a card verification without charge to the customer. If the customer does not show up at the property, it is possible to charge the cost of the first night of stay.
     * - GUARANTEED_PENALTY: reservation, through a card verification without charge to the customer. An automatic charge of the predetermined penalty is made in case a guest does not show up at the property.
     * - BUNDLE: booking of a package containing several services provided by the same structure, for example stay + excursion + restaurant + tourist bus.
     *
     * @optional
     *
     * @return $this
     *
     * @example GUARANTEED
     */
    public function setReservationType(?string $value): self
    {
        return $value === null ? $this->_unset('reservationType') : $this->_set('reservationType', $value);
    }

    /**
     * Structure identifier unique in the merchant domain.
     *
     * @optional
     * Minimum length: 1
     * Maximum length: 36
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 99a172e5-423c-4648-9895-4cb5d1d43134
     */
    public function getStructureId(): ?string
    {
        return $this->_getString('structureId');
    }

    /**
     * Structure identifier unique in the merchant domain.
     *
     * @optional
     * Minimum length: 1
     * Maximum length: 36
     *
     * @return $this
     *
     * @example 99a172e5-423c-4648-9895-4cb5d1d43134
     */
    public function setStructureId(?string $value): self
    {
        return $value === null ? $this->_unset('structureId') : $this->_set('structureId', $value);
    }

    /**
     * Facility T&C identifier array. Insertion of terms and conditions
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return string[]|null
     */
    public function getTermsAndConditionsIds(): ?array
    {
        return $this->_getStringArray('termsAndConditionsIds');
    }

    /**
     * Facility T&C identifier array. Insertion of terms and conditions
     *
     * @param string[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setTermsAndConditionsIds(?array $value): self
    {
        return $value === null ? $this->_unset('termsAndConditionsIds') : $this->_setStringArray('termsAndConditionsIds', $value);
    }

    /**
     * Check in time in ISO 8601 format.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2022-09-01
     */
    public function getCheckInDate(): ?string
    {
        return $this->_getString('checkInDate');
    }

    /**
     * Check in time in ISO 8601 format.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2022-09-01
     */
    public function setCheckInDate(?string $value): self
    {
        return $value === null ? $this->_unset('checkInDate') : $this->_set('checkInDate', $value);
    }

    /**
     * Check in from time to be intended as a local time of the structure.
     *
     * @optional
     * Maximum length: 11
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 09:00
     */
    public function getCheckInFromTime(): ?string
    {
        return $this->_getString('checkInFromTime');
    }

    /**
     * Check in from time to be intended as a local time of the structure.
     *
     * @optional
     * Maximum length: 11
     *
     * @return $this
     *
     * @example 09:00
     */
    public function setCheckInFromTime(?string $value): self
    {
        return $value === null ? $this->_unset('checkInFromTime') : $this->_set('checkInFromTime', $value);
    }

    /**
     * Check in to time to be intended as a local time of the structure.
     *
     * @optional
     * Maximum length: 11
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 20:00
     */
    public function getCheckInToTime(): ?string
    {
        return $this->_getString('checkInToTime');
    }

    /**
     * Check in to time to be intended as a local time of the structure.
     *
     * @optional
     * Maximum length: 11
     *
     * @return $this
     *
     * @example 20:00
     */
    public function setCheckInToTime(?string $value): self
    {
        return $value === null ? $this->_unset('checkInToTime') : $this->_set('checkInToTime', $value);
    }

    /**
     * Check out time in ISO 8601 format.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2022-09-05
     */
    public function getCheckOutDate(): ?string
    {
        return $this->_getString('checkOutDate');
    }

    /**
     * Check out time in ISO 8601 format.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2022-09-05
     */
    public function setCheckOutDate(?string $value): self
    {
        return $value === null ? $this->_unset('checkOutDate') : $this->_set('checkOutDate', $value);
    }

    /**
     * Check out from time to be intended as a local time of the structure.
     *
     * @optional
     * Maximum length: 11
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 09:00
     */
    public function getCheckOutFromTime(): ?string
    {
        return $this->_getString('checkOutFromTime');
    }

    /**
     * Check out from time to be intended as a local time of the structure.
     *
     * @optional
     * Maximum length: 11
     *
     * @return $this
     *
     * @example 09:00
     */
    public function setCheckOutFromTime(?string $value): self
    {
        return $value === null ? $this->_unset('checkOutFromTime') : $this->_set('checkOutFromTime', $value);
    }

    /**
     * Check out to time to be intended as a local time of the structure.
     *
     * @optional
     * Maximum length: 11
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 20:00
     */
    public function getCheckOutToTime(): ?string
    {
        return $this->_getString('checkOutToTime');
    }

    /**
     * Check out to time to be intended as a local time of the structure.
     *
     * @optional
     * Maximum length: 11
     *
     * @return $this
     *
     * @example 20:00
     */
    public function setCheckOutToTime(?string $value): self
    {
        return $value === null ? $this->_unset('checkOutToTime') : $this->_set('checkOutToTime', $value);
    }

    /**
     * Number of days or night for the reservation.
     *
     * @optional
     * Maximum length: 4
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 4
     */
    public function getReservationPeriod(): ?string
    {
        return $this->_getString('reservationPeriod');
    }

    /**
     * Number of days or night for the reservation.
     *
     * @optional
     * Maximum length: 4
     *
     * @return $this
     *
     * @example 4
     */
    public function setReservationPeriod(?string $value): self
    {
        return $value === null ? $this->_unset('reservationPeriod') : $this->_set('reservationPeriod', $value);
    }

    /**
     * Number of people for the reservation.
     *
     * @optional
     * Maximum length: 4
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2
     */
    public function getCustomerNumber(): ?string
    {
        return $this->_getString('customerNumber');
    }

    /**
     * Number of people for the reservation.
     *
     * @optional
     * Maximum length: 4
     *
     * @return $this
     *
     * @example 2
     */
    public function setCustomerNumber(?string $value): self
    {
        return $value === null ? $this->_unset('customerNumber') : $this->_set('customerNumber', $value);
    }

    /**
     * The name of the reservation holder.
     *
     * @optional
     * Maximum length: 255
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example Mario
     */
    public function getCustomerName(): ?string
    {
        return $this->_getString('customerName');
    }

    /**
     * The name of the reservation holder.
     *
     * @optional
     * Maximum length: 255
     *
     * @return $this
     *
     * @example Mario
     */
    public function setCustomerName(?string $value): self
    {
        return $value === null ? $this->_unset('customerName') : $this->_set('customerName', $value);
    }

    /**
     * The surname of the reservation holder.
     *
     * @optional
     * Maximum length: 255
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example Rossi
     */
    public function getCustomerSurname(): ?string
    {
        return $this->_getString('customerSurname');
    }

    /**
     * The surname of the reservation holder.
     *
     * @optional
     * Maximum length: 255
     *
     * @return $this
     *
     * @example Rossi
     */
    public function setCustomerSurname(?string $value): self
    {
        return $value === null ? $this->_unset('customerSurname') : $this->_set('customerSurname', $value);
    }

    /**
     * Expiration date for Paybylink.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 2022-09-01
     */
    public function getLinkExpirationDate(): ?string
    {
        return $this->_getString('linkExpirationDate');
    }

    /**
     * Expiration date for Paybylink.
     *
     * @optional
     *
     * @return $this
     *
     * @example 2022-09-01
     */
    public function setLinkExpirationDate(?string $value): self
    {
        return $value === null ? $this->_unset('linkExpirationDate') : $this->_set('linkExpirationDate', $value);
    }

    /**
     * Accounting typology:
     * - INSTANT
     * - DELAYED
     * - INSTALLMENT: delayed
     * Delayed and installment Collection
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example INSTANT
     */
    public function getCollectionType(): ?string
    {
        return $this->_getString('collectionType');
    }

    /**
     * Accounting typology:
     * - INSTANT
     * - DELAYED
     * - INSTALLMENT: delayed
     * Delayed and installment Collection
     *
     * @optional
     *
     * @return $this
     *
     * @example INSTANT
     */
    public function setCollectionType(?string $value): self
    {
        return $value === null ? $this->_unset('collectionType') : $this->_set('collectionType', $value);
    }

    /**
     * Customer identifier for this transaction.
     *
     * @optional
     * Maximum length: 27
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example mcid97295873
     */
    public function getCustomerId(): ?string
    {
        return $this->_getString('customerId');
    }

    /**
     * Customer identifier for this transaction.
     *
     * @optional
     * Maximum length: 27
     *
     * @return $this
     *
     * @example mcid97295873
     */
    public function setCustomerId(?string $value): self
    {
        return $value === null ? $this->_unset('customerId') : $this->_set('customerId', $value);
    }

    /**
     * Additional transaction description.
     *
     * @optional
     * Maximum length: 255
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example weekend promotion
     */
    public function getCustomField(): ?string
    {
        return $this->_getString('customField');
    }

    /**
     * Additional transaction description.
     *
     * @optional
     * Maximum length: 255
     *
     * @return $this
     *
     * @example weekend promotion
     */
    public function setCustomField(?string $value): self
    {
        return $value === null ? $this->_unset('customField') : $this->_set('customField', $value);
    }

    /**
     * The tax code of the customer.
     *
     * @optional
     * Maximum length: 21
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example SVTTRP95P03C478T
     */
    public function getCustomerTaxCode(): ?string
    {
        return $this->_getString('customerTaxCode');
    }

    /**
     * The tax code of the customer.
     *
     * @optional
     * Maximum length: 21
     *
     * @return $this
     *
     * @example SVTTRP95P03C478T
     */
    public function setCustomerTaxCode(?string $value): self
    {
        return $value === null ? $this->_unset('customerTaxCode') : $this->_set('customerTaxCode', $value);
    }

    /**
     * Object containing the customer detail. Sending the content of this object increases the security level of the transaction, thus increasing the probability that two-factor authentication will not be requested in the payment.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getCustomerInfo(): ?CustomerInfo
    {
        return $this->_getEntity('customerInfo', CustomerInfo::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\Reservation::getCustomerInfo()
     */
    public function getOrCreateCustomerInfo(): CustomerInfo
    {
        $result = $this->getCustomerInfo();
        if ($result === null) {
            $this->setCustomerInfo($result = new CustomerInfo());
        }

        return $result;
    }

    /**
     * Object containing the customer detail. Sending the content of this object increases the security level of the transaction, thus increasing the probability that two-factor authentication will not be requested in the payment.
     *
     * @optional
     *
     * @return $this
     */
    public function setCustomerInfo(?CustomerInfo $value): self
    {
        return $value === null ? $this->_unset('customerInfo') : $this->_set('customerInfo', $value);
    }

    /**
     * Array containing the detail of the installments. Mandatory with "collectionType" set to "INSTALLMENT".
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\Entity\Installment[]|null
     */
    public function getInstallments(): ?array
    {
        return $this->_getEntityArray('installments', Installment::class);
    }

    /**
     * Array containing the detail of the installments. Mandatory with "collectionType" set to "INSTALLMENT".
     *
     * @param \MLocati\Nexi\Entity\Installment[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setInstallments(?array $value): self
    {
        return $value === null ? $this->_unset('installments') : $this->_setEntityArray('installments', Installment::class, $value);
    }

    /**
     * Array containing the transaction summary.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\Entity\TransactionSummary[]|null
     */
    public function getTransactionSummary(): ?array
    {
        return $this->_getEntityArray('transactionSummary', TransactionSummary::class);
    }

    /**
     * Array containing the transaction summary.
     *
     * @param \MLocati\Nexi\Entity\TransactionSummary[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setTransactionSummary(?array $value): self
    {
        return $value === null ? $this->_unset('transactionSummary') : $this->_setEntityArray('transactionSummary', TransactionSummary::class, $value);
    }

    /**
     * Object containing the details for canceling the reservation.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     */
    public function getCancelationDetails(): ?CancelationDetails
    {
        return $this->_getEntity('CancelationDetails', CancelationDetails::class);
    }

    /**
     * @see \MLocati\Nexi\Entity\Reservation::getCancelationDetails()
     */
    public function getOrCreateCancelationDetails(): CancelationDetails
    {
        $result = $this->getCancelationDetails();
        if ($result === null) {
            $this->setCancelationDetails($result = new CancelationDetails());
        }

        return $result;
    }

    /**
     * Object containing the details for canceling the reservation.
     *
     * @optional
     *
     * @return $this
     */
    public function setCancelationDetails(?CancelationDetails $value): self
    {
        return $value === null ? $this->_unset('CancelationDetails') : $this->_set('CancelationDetails', $value);
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Entity::getRequiredFields()
     */
    protected function getRequiredFields(): array
    {
        return [
        ];
    }
}
