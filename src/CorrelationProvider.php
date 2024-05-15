<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb;

interface CorrelationProvider
{
    /**
     * Get the value of the Correlation-Id header that uniquely identify a request.
     *
     * @param string $method the HTTP method being invoked ('GET', 'POST', ...)
     * @param string $url the URL being invoked ('https://www.example.com/path')
     * @param string $requestBody the raw data being sent (empty string if none)
     */
    public function getCorrelationID(string $method, string $url, string $requestBody): string;
}
