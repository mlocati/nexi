<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Test\Cases\Configuration;

use MLocati\Nexi\XPayWeb\Configuration;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;

class FromArrayTest extends TestCase
{
    public static function provideValidCases(): array
    {
        return [
            [
                ['environment' => 'test'],
                Configuration::DEFAULT_BASEURL_TEST,
                Configuration::DEFAULT_APIKEY_TEST,
            ],
            [
                ['apiKey' => 'my-api-key'],
                Configuration::DEFAULT_BASEURL_PRODUCTION,
                'my-api-key',
            ],
            [
                ['baseUrl' => 'http://my.base.url', 'apiKey' => 'my-api-key'],
                'http://my.base.url',
                'my-api-key',
            ],
            [
                ['environment' => 'test', 'apiKey' => 'my-api-key'],
                Configuration::DEFAULT_BASEURL_TEST,
                'my-api-key',
            ],
            [
                ['environment' => 'production', 'apiKey' => 'my-api-key'],
                Configuration::DEFAULT_BASEURL_PRODUCTION,
                'my-api-key',
            ],
            [
                ['environment' => 'invalid', 'apiKey' => 'my-api-key'],
                Configuration::DEFAULT_BASEURL_PRODUCTION,
                'my-api-key',
            ],
            [
                ['environment' => 'invalid', 'baseUrl' => 'http://my.base.url', 'apiKey' => 'my-api-key'],
                'http://my.base.url',
                'my-api-key',
            ],
        ];
    }

    /**
     * @dataProvider provideValidCases
     */
    public function testValidCase(array $data, string $expectedBaseUrl, string $expectedApyKey): void
    {
        $configuration = new Configuration\FromArray($data);
        $this->assertSame($expectedBaseUrl, $configuration->getBaseUrl());
        $this->assertSame($expectedApyKey, $configuration->getApiKey());
    }

    public static function provideInvalidCases(): array
    {
        return [
            [
                [],
                RuntimeException::class,
            ],
            [
                ['baseUrl' => 'wrong.base.url', 'apiKey' => 'my-api-key'],
                RuntimeException::class,
            ],
        ];
    }

    /**
     * @dataProvider provideInvalidCases
     */
    public function testInvalidCase(array $data, string $expectedException): void
    {
        try {
            new Configuration\FromArray($data);
            $exception = null;
        } catch (Throwable $x) {
            $exception = $x;
        }
        $this->assertInstanceOf($expectedException, $exception);
    }
}
