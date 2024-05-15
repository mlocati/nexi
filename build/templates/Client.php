<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb;

use MLocati\Nexi\XPayWeb\HttpClient\Response;
use MLocati\Nexi\XPayWeb\Service\QueryEntityInterface;
use stdClass;

/* <<TOPCOMMENT>> */

class Client
{
    /**
     * @var \MLocati\Nexi\XPayWeb\Configuration
     */
    protected $configuration;

    /**
     * @var \MLocati\Nexi\XPayWeb\HttpClient
     */
    protected $httpClient;

    /**
     * @var \MLocati\Nexi\XPayWeb\CorrelationProvider
     */
    protected $correlationProvider;

    /**
     * @var \MLocati\Nexi\XPayWeb\Entity\Webhook\Request|null
     */
    private $notificationRequest;

    /**
     * @throws \MLocati\Nexi\XPayWeb\Exception\NoHttpClient if $httpClient is NULL and no HTTP client is available
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
     * @throws \MLocati\Nexi\XPayWeb\Exception\InvalidJson is no (valid) request data is detected
     * @throws \MLocati\Nexi\XPayWeb\Exception\MissingField is the received data does not contain a security token
     */
    public function getNotificationRequest(): Entity\Webhook\Request
    {
        if ($this->notificationRequest === null) {
            $data = $this->decodeJsonToObject(file_get_contents('php://input') ?: '');
            $notificationRequest = new Entity\Webhook\Request($data);
            $notificationRequest->checkRequiredFields('/* <<WEBHOOK_METHODNAME>> */', '/* <<WEBHOOK_INPUT>> */');
            if ((string) $notificationRequest->getSecurityToken() === '') {
                throw new Exception\MissingField('securityToken');
            }
            $this->notificationRequest = $notificationRequest;
        }

        return $this->notificationRequest;
    }

    /* <<METHODS>> */

    /**
     * @throws \MLocati\Nexi\XPayWeb\Exception\NoHttpClient
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
     * @param \MLocati\Nexi\XPayWeb\Entity|\MLocati\Nexi\XPayWeb\Entity[]|null $requestBody
     */
    protected function invoke(string $method, string $url, int $headerFlags, $requestBody = null, string &$idempotencyKey = ''): HttpClient\Response
    {
        if ($requestBody === null) {
            $requestBodyJson = '';
        } else {
            $requestBodyJson = json_encode($requestBody, JSON_UNESCAPED_SLASHES);
            if ($requestBodyJson === false) {
                throw new \RuntimeException('Failed to create the JSON data: ' . (json_last_error_msg() ?: 'unknown reason'));
            }
        }
        $headers = $this->buildHeaders($method, $url, $requestBodyJson, $headerFlags, $idempotencyKey);

        return $this->httpClient->invoke($method, $url, $headers, $requestBodyJson);
    }

    protected function buildHeaders(string $method, string $url, string $requestBody, int $flags, string &$idempotencyKey): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        if ($flags & /* <<HEADERFLAG_XAPIKEY>> */ 0 /* <</HEADERFLAG_XAPIKEY>> */) {
            $headers['X-Api-Key'] = $this->configuration->getApiKey();
        }
        if ($flags & /* <<HEADERFLAG_CORRELATIONID>> */ 0 /* <</HEADERFLAG_CORRELATIONID>> */) {
            $headers['Correlation-Id'] = $this->correlationProvider->getCorrelationID($method, $url, $requestBody);
        }
        if ($flags & /* <<HEADERFLAG_IDEMPOTENCYKEY>> */ 0 /* <</HEADERFLAG_IDEMPOTENCYKEY>> */) {
            if ($idempotencyKey === '') {
                $idempotencyKey = $this->generateIdempotencyKey();
            }
            $headers['Idempotency-Key'] = $idempotencyKey;
        }

        return $headers;
    }

    /**
     * @throws \MLocati\Nexi\XPayWeb\Exception\InvalidJson
     */
    protected function decodeJsonToArray(string $json): array
    {
        $data = $this->decodeJson($json);
        if (is_array($data)) {
            return $data;
        }
        throw new Exception\InvalidJson($json, 'The JSON does NOT represent an array');
    }

    /**
     * @throws \MLocati\Nexi\XPayWeb\Exception\InvalidJson
     */
    protected function decodeJsonToObject(string $json): stdClass
    {
        $data = $this->decodeJson($json);
        if ($data instanceof stdClass) {
            return $data;
        }

        throw new Exception\InvalidJson($json, 'The JSON does NOT represent an object');
    }

    /**
     * @throws \MLocati\Nexi\XPayWeb\Exception\ErrorResponse\Detailed
     * @throws \MLocati\Nexi\XPayWeb\Exception\ErrorResponse
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

    /**
     * Maximum length: 63 characters
     */
    protected function generateIdempotencyKey(): string
    {
        return bin2hex(random_bytes(31));
    }

    /**
     * @throws \MLocati\Nexi\XPayWeb\Exception\InvalidJson
     */
    private function decodeJson(string $json)
    {
        if ($json === 'null') {
            return null;
        }
        $decoded = json_decode($json);
        if ($decoded === null) {
            throw new Exception\InvalidJson($json);
        }

        return $decoded;
    }
}
