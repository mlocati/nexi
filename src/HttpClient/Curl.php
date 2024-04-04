<?php

declare(strict_types=1);

namespace MLocati\Nexi\HttpClient;

use MLocati\Nexi\Exception\HttpRequestFailed;
use MLocati\Nexi\HttpClient;

class Curl implements HttpClient
{
    /**
     * @var int
     */
    private $flags;

    public function __construct(int $flags = 0)
    {
        $this->flags = $flags;
    }

    public static function isAvailable(): bool
    {
        return extension_loaded('curl');
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\HttpClient::invoke()
     */
    public function invoke(string $method, string $url, array $headers, string $rawBody): Response
    {
        $options = $this->buildOptions($method, $url, $headers, $rawBody);
        $ch = curl_init();
        if ($ch === false) {
            throw new HttpRequestFailed('curl_init() failed');
        }
        try {
            if (curl_setopt_array($ch, $options) === false) {
                $err = curl_error($ch);

                throw new HttpRequestFailed('curl_setopt_array() failed' . ($err ? ": {$err}" : ''));
            }
            $responseBody = curl_exec($ch);
            if ($responseBody === false) {
                $err = curl_error($ch);

                throw new HttpRequestFailed('curl_exec() failed' . ($err ? ": {$err}" : ''));
            }
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (!is_numeric($statusCode)) {
                $err = curl_error($ch);

                throw new HttpRequestFailed('curl_getinfo() failed' . ($err ? ": {$err}" : ''));
            }
        } finally {
            curl_close($ch);
        }

        return new Response((int) $statusCode, $responseBody);
    }

    protected function buildOptions(string $method, string $url, array $headers, string $rawBody): array
    {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => false,
        ];
        if (($this->flags & static::FLAG_ALLOWINSECUREHTTPS) === static::FLAG_ALLOWINSECUREHTTPS) {
            $options += [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ];
        }
        if ($rawBody !== '') {
            $options[CURLOPT_POSTFIELDS] = $rawBody;
        }
        if ($headers !== '') {
            $join = [];
            foreach ($headers as $key => $value) {
                $join[] = "{$key}: {$value}";
            }
            $options[CURLOPT_HTTPHEADER] = $join;
        }
        switch ($method) {
            case 'GET':
                $options[CURLOPT_HTTPGET] = true;
                break;
            case 'POST':
                $options[CURLOPT_POST] = true;
                break;
            default:
                $options[CURLOPT_CUSTOMREQUEST] = $method;
                break;
        }

        return $options;
    }
}
