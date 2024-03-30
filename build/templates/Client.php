<?php

declare(strict_types=1);

namespace MLocati\Nexi;

use MLocati\Nexi\HttpClient\Response;
use MLocati\Nexi\Service\QueryEntityInterface;

/* <<TOPCOMMENT>> */

class Client
{
    /**
     * @var \MLocati\Nexi\Configuration
     */
    protected $configuration;

    /**
     * @var \MLocati\Nexi\HttpClient
     */
    protected $httpClient;

    /**
     * @var \MLocati\Nexi\CorrelationProvider
     */
    protected $correlationProvider;

    /**
     * @var \MLocati\Nexi\Entity\Webhook\Request|null
     */
    private $notificationRequest;

    /**
     * @throws \MLocati\Nexi\Exception\NoHttpClient if $httpClient is NULL and no HTTP client is available
     */
    public function __construct(
        Configuration $configuration,
        ?HttpClient $httpClient = null,
        ?CorrelationProvider $correlationProvider = null
    ) {
        $this->configuration = $configuration;
        $this->httpClient = $httpClient ?? $this->buildHttpClient();
        $this->correlationProvider = $correlationProvider ?? $this->buildCorrelationProvider();
    }

    /**
     * @throws \MLocati\Nexi\Exception\InvalidJson is no (valid) request data is detected
     * @throws \MLocati\Nexi\Exception\MissingField is the received data does not contain a security token
     */
    public function getNotificationRequest(): Entity\Webhook\Request
    {
        if ($this->notificationRequest === null) {
            $data = $this->decodeJsonToArray(file_get_contents('php://input') ?: '');
            $notificationRequest = new Entity\Webhook\Request($data);
            if ((string) $notificationRequest->getSecurityToken() === '') {
                throw new Exception\MissingField('securityToken');
            }
            $this->notificationRequest = $notificationRequest;
        }

        return $this->notificationRequest;
    }

    /* <<METHODS>> */

    /**
     * @throws \MLocati\Nexi\Exception\NoHttpClient
     */
    protected function buildHttpClient(): HttpClient
    {
        if (HttpClient\Curl::isAvailable()) {
            return new HttpClient\Curl();
        }
        if (HttpClient\StreamWrapper::isAvailable()) {
            return new HttpClient\StreamWrapper();
        }
        throw new Exception\NoHttpClient();
    }

    protected function buildCorrelationProvider(): CorrelationProvider
    {
        if (CorrelationProvider\UUID::isAvailable()) {
            return new CorrelationProvider\UUID();
        }

        return new CorrelationProvider\Random();
    }

    protected function buildUrl(string $path, array $pathParams = [], ?QueryEntityInterface $query = null): string
    {
        $matches = null;
        if (preg_match_all('/\\{(?<name>[^\\}]+)\\}/', $path, $matches) !== 0) {
            $names = $matches['name'];
            while ($names !== []) {
                $name = array_shift($names);
                if (!array_key_exists($name, $pathParams)) {
                    throw new \RuntimeException('Missing required URL parameter: ' . $name);
                }
                $path = str_replace('{' . $name . '}', rawurlencode((string) $pathParams[$name]), $path);
                unset($pathParams[$name]);
            }
        }
        if ($pathParams !== []) {
            throw new \RuntimeException("Unexpected URL parameters:\n- " . implode("\n- ", array_keys($pathParams)));
        }
        $url = rtrim($this->configuration->getBaseUrl(), '/') . '/' . ltrim($path, '/');
        $qs = $query === null ? '' : $query->getQuerystring();
        if ($qs !== '') {
            $url .= '?' . $qs;
        }

        return $url;
    }

    /**
     * @param \MLocati\Nexi\Entity|\MLocati\Nexi\Entity[]|null $requestBody
     */
    protected function invoke(string $method, string $url, int $headerFlags, $requestBody = null): HttpClient\Response
    {
        $headers = $this->buildHeaders($headerFlags);
        if ($requestBody === null) {
            $requestBodyJson = '';
        } else {
            $requestBodyJson = json_encode($requestBody, JSON_THROW_ON_ERROR);
        }

        return $this->httpClient->invoke($method, $url, $headers, $requestBodyJson);
    }

    protected function buildHeaders(int $flags): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        if ($flags & /* <<HEADERFLAG_XAPIKEY>> */ 0 /* <</HEADERFLAG_XAPIKEY>> */) {
            $headers['X-Api-Key'] = $this->configuration->getApiKey();
        }
        if ($flags & /* <<HEADERFLAG_CORRELATIONID>> */ 0 /* <</HEADERFLAG_CORRELATIONID>> */) {
            $headers['Correlation-Id'] = $this->correlationProvider->getCorrelationID();
        }
        if ($flags & /* <<HEADERFLAG_IDEMPOTENCYKEY>> */ 0 /* <</HEADERFLAG_IDEMPOTENCYKEY>> */) {
            throw new \RuntimeException('@todo');
        }

        return $headers;
    }

    /**
     * @throws \MLocati\Nexi\Exception\InvalidJson
     */
    protected function decodeJsonToArray(string $json): array
    {
        if ($json === 'null') {
            $decoded = null;
        } else {
            $decoded = json_decode($json, true);
            if ($decoded === null) {
                throw new Exception\InvalidJson($json);
            }
        }
        if (!is_array($decoded)) {
            throw new Exception\InvalidJson($json, 'The JSON does NOT represent an array');
        }

        return $decoded;
    }

    /**
     * @throws \MLocati\Nexi\Exception\ErrorResponse\Detailed
     * @throws \MLocati\Nexi\Exception\ErrorResponse
     */
    protected function throwErrorResponse(Response $response, array $cases): void
    {
        foreach ($cases as $case) {
            if ($case['from'] <= $response->getStatusCode() && $response->getStatusCode() <= $case['from']) {
                $message = $case['description'];
                if ($message === '') {
                    $message = "Request failed with return code {$response->getStatusCode()}";
                }
                if (empty($case['detailed'])) {
                    throw new Exception\ErrorResponse($response->getStatusCode(), $message);
                }
                $data = $this->decodeJsonToArray($response->getBody());
                $errors = new Entity\Errors($data);

                throw new Exception\ErrorResponse\Detailed($response->getStatusCode(), $message, $errors);
            }
        }

        throw new Exception\ErrorResponse($response->getStatusCode(), "Request failed with return code {$response->getStatusCode()}");
    }
}
