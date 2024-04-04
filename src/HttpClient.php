<?php

declare(strict_types=1);

namespace MLocati\Nexi;

interface HttpClient
{
    /**
     * Allow insecure HTTPS connections?
     *
     * @var int
     */
    const FLAG_ALLOWINSECUREHTTPS = 0b1;

    /**
     * Perform an HTTP request.
     *
     * @param string $method the request method ('GET', 'POST', ...)
     * @param array $headers header name => header value)
     * @param string $rawBody the raw body to be sent (empty string if none)
     *
     * @throws \MLocati\Nexi\Exception\HttpRequestFailed
     */
    public function invoke(string $method, string $url, array $headers, string $rawBody): HttpClient\Response;
}
