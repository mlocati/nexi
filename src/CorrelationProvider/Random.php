<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\CorrelationProvider;

use MLocati\Nexi\XPayWeb\CorrelationProvider;

class Random implements CorrelationProvider
{
    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\XPayWeb\CorrelationProvider::getCorrelationID()
     */
    public function getCorrelationID(string $method, string $url, string $requestBody): string
    {
        // Limit on 32-bit systems is 7FFFFFFF
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 1st chunk
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            // 2nd chunk
            mt_rand(0, 0xFFFF),
            // 3rd chunk
            mt_rand(0, 0xFFFF),
            // 4th chunk
            mt_rand(0, 0xFFFF),
            // 5th chunk
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF)
        );
    }
}
