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
 * @see https://developer.nexi.it/en/api/get-orders#tab_response
 * @see https://developer.nexi.it/en/api/get-orders-orderId#tab_response
 * @see https://developer.nexi.it/en/api/get-reservations#tab_response
 * @see https://developer.nexi.it/en/api/get-reservations-reservationId#tab_response
 * @see https://developer.nexi.it/en/api/post-orders-2steps-init#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-2steps-payment#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-3steps-init#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-3steps-payment#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-build#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-card_verification#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-hpp#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-mit#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-moto#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-paybylink#tab_body
 * @see https://developer.nexi.it/en/api/post-orders-virtual_card#tab_body
 * @see https://developer.nexi.it/en/api/post-reservations#tab_body
 */
class TransactionSummary extends Entity
{
    /**
     * Language to be used on the transaction summary details, ISO 639-2.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example eng
     */
    public function getLanguage(): ?string
    {
        return $this->_getString('language');
    }

    /**
     * Language to be used on the transaction summary details, ISO 639-2.
     *
     * @optional
     *
     * @return $this
     *
     * @example eng
     */
    public function setLanguage(?string $value): self
    {
        return $value === null ? $this->_unset('language') : $this->_set('language', $value);
    }

    /**
     * Array containing the summary list.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\Entity\Summary[]|null
     */
    public function getSummaryList(): ?array
    {
        return $this->_getEntityArray('summaryList', Summary::class);
    }

    /**
     * Array containing the summary list.
     *
     * @param \MLocati\Nexi\Entity\Summary[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setSummaryList(?array $value): self
    {
        return $value === null ? $this->_unset('summaryList') : $this->_setEntityArray('summaryList', Summary::class, $value);
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
