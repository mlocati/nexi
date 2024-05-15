<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\CorrelationProvider;

use MLocati\Nexi\XPayWeb\CorrelationProvider;

class UUID implements CorrelationProvider
{
    public static function isAvailable(): bool
    {
        return function_exists('uuid_create') && defined('UUID_TYPE_RANDOM');
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\XPayWeb\CorrelationProvider::getCorrelationID()
     */
    public function getCorrelationID(string $method, string $url, string $requestBody): string
    {
        return uuid_create(UUID_TYPE_DEFAULT);
    }
}
