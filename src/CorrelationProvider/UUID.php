<?php

declare(strict_types=1);

namespace MLocati\Nexi\CorrelationProvider;

use MLocati\Nexi\CorrelationProvider;

class UUID implements CorrelationProvider
{
    public static function isAvailable(): bool
    {
        return function_exists('uuid_create') && defined('UUID_TYPE_RANDOM');
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\CorrelationProvider::getCorrelationID()
     */
    public function getCorrelationID(): string
    {
        return uuid_create(UUID_TYPE_DEFAULT);
    }
}
