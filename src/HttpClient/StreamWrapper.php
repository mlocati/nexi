<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\HttpClient;

use MLocati\Nexi\XPayWeb\Exception\HttpRequestFailed;
use MLocati\Nexi\XPayWeb\HttpClient;

class StreamWrapper implements HttpClient
{
    public static function isAvailable(): bool
    {
        return in_array('http', stream_get_wrappers(), true);
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\XPayWeb\HttpClient::invoke()
     */
    public function invoke(string $method, string $url, array $headers, string $rawBody): Response
    {
        $context = $this->createContext($method, $headers, $rawBody);
        $whyNot = '';
        $http_response_header = [];
        set_error_handler(
            static function ($errno, $errstr) use (&$whyNot) {
                if ($whyNot === '' && is_string($errstr)) {
                    $whyNot = trim($errstr);
                }
            },
            -1
        );
        try {
            $responseBody = file_get_contents($url, false, $context);
        } finally {
            restore_error_handler();
        }
        if ($responseBody === false) {
            throw new HttpRequestFailed($whyNot ?: 'file_get_contents() failed');
        }
        $statusCode = $this->extractStatusCode($http_response_header);
        if ($statusCode === null) {
            throw new HttpRequestFailed('Failed to retrieve the HTTP status code');
        }

        return new Response($statusCode, $responseBody);
    }

    /**
     * @return resource
     */
    protected function createContext(string $method, array $headers, string $rawBody)
    {
        $options = [
            'https' => $this->createHttpContextOptions($method, $headers, $rawBody),
            'ssl' => $this->createSslContextOptions(),
        ];

        return stream_context_create($options);
    }

    protected function createHttpContextOptions(string $method, array $headers, string $rawBody): array
    {
        $options = [
            'method' => $method,
            'ignore_errors' => true,
        ];
        if ($rawBody !== '') {
            $options['content'] = $rawBody;
        }
        if ($headers !== '') {
            $options['header'] = [];
            foreach ($headers as $key => $value) {
                $options['header'][] = "{$key}: {$value}";
            }
        }

        return $options;
    }

    protected function createSslContextOptions(): array
    {
        return [];
    }

    protected function extractStatusCode(array $httpResponseHeaders): ?int
    {
        $chunks = $httpResponseHeaders === [] ? [] : explode(' ', $httpResponseHeaders[0], 3);

        return isset($chunks[1]) && is_numeric($chunks[1]) ? (int) $chunks[1] : null;
    }
}
