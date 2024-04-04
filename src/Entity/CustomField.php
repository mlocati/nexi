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
 * @see https://developer.nexi.it/en/api/get-structures#tab_response
 * @see https://developer.nexi.it/en/api/get-structures-structureId#tab_response
 * @see https://developer.nexi.it/en/api/post-structures#tab_body
 */
class CustomField extends Entity
{
    /**
     * The unique identifier for custom field.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example 0d0f3240-efd3-4c6b-b305-b8ec3bb7a99a
     */
    public function getCustomFieldId(): ?string
    {
        return $this->_getString('customFieldId');
    }

    /**
     * The unique identifier for custom field.
     *
     * @optional
     *
     * @return $this
     *
     * @example 0d0f3240-efd3-4c6b-b305-b8ec3bb7a99a
     */
    public function setCustomFieldId(?string $value): self
    {
        return $value === null ? $this->_unset('customFieldId') : $this->_set('customFieldId', $value);
    }

    /**
     * The custom field name to be intend as title.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @example Animali domestici
     */
    public function getCustomFieldTitle(): ?string
    {
        return $this->_getString('customFieldTitle');
    }

    /**
     * The custom field name to be intend as title.
     *
     * @optional
     *
     * @return $this
     *
     * @example Animali domestici
     */
    public function setCustomFieldTitle(?string $value): self
    {
        return $value === null ? $this->_unset('customFieldTitle') : $this->_set('customFieldTitle', $value);
    }

    /**
     * Array containing the translations of the custom fields.
     *
     * @optional
     *
     * @throws \MLocati\Nexi\Exception\WrongFieldType
     *
     * @return \MLocati\Nexi\Entity\CustomFieldTranslation[]|null
     */
    public function getCustomFieldTranslations(): ?array
    {
        return $this->_getEntityArray('customFieldTranslations', CustomFieldTranslation::class);
    }

    /**
     * Array containing the translations of the custom fields.
     *
     * @param \MLocati\Nexi\Entity\CustomFieldTranslation[]|null $value
     *
     * @optional
     *
     * @return $this
     */
    public function setCustomFieldTranslations(?array $value): self
    {
        return $value === null ? $this->_unset('customFieldTranslations') : $this->_setEntityArray('customFieldTranslations', CustomFieldTranslation::class, $value);
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
