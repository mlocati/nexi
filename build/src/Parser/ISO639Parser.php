<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\Parser;

use Generator;
use MLocati\Nexi\XPayWeb\Build\API;
use MLocati\Nexi\XPayWeb\Build\Parser;
use RuntimeException;

/**
 * @link https://www.loc.gov/standards/iso639-2/
 */
class ISO639Parser implements Parser
{
    public const PATH = '/standards/iso639-2/ISO-639-2_utf-8.txt';

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\XPayWeb\Build\Parser::shouldHandlePath()
     */
    public function shouldHandlePath(string $path): bool
    {
        return $path === static::PATH;
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\XPayWeb\Build\Parser::parse()
     */
    public function parse(string $see, string $path, string $contents, API $api): void
    {
        $alpha3ToAlpha2Map = [];
        foreach ($this->listLines($contents) as $line) {
            $this->parseLine($line, $alpha3ToAlpha2Map);
        }
        if ($alpha3ToAlpha2Map === []) {
            throw new RuntimeException('No ISO 639 language codes found');
        }
        $api->setISO639Alpha3ToAlpha2Map($alpha3ToAlpha2Map);
    }

    /**
     * @return \Generator<string>
     */
    private function listLines(string $contents): Generator
    {
        foreach (preg_split('/[\\r\\n]+/', $contents, -1, PREG_SPLIT_NO_EMPTY) as $line) {
            yield $line;
        }
    }

    private function parseLine(string $line, array &$alpha3ToAlpha2Map): void
    {
        $chunks = explode('|', $line);
        if (count($chunks) !== 5) {
            throw new RuntimeException("Unrecognized ISO 639 line: {$line}");
        }
        $chunks = array_map('trim', $chunks);
        [
            // alpha-3 (bibliographic) code
            $bibliographicAlpha3,
            // alpha-3 (terminologic) code
            $terminologicAlpha3,
            // alpha-2 code
            $alpha2,
            // English name
            ,
            // French name
            ,
        ] = $chunks;
        if ($alpha2 === '' || ($bibliographicAlpha3 === '' && $terminologicAlpha3 === '')) {
            return;
        }
        if ($bibliographicAlpha3 === '' || $terminologicAlpha3 === '') {
            $alpha3List = [$bibliographicAlpha3 . $terminologicAlpha3];
        } elseif ($bibliographicAlpha3 === $terminologicAlpha3) {
            $alpha3List = [$bibliographicAlpha3];
        } else {
            $alpha3List = [$bibliographicAlpha3, $terminologicAlpha3];
        }
        foreach ($alpha3List as $alpha3) {
            if (isset($alpha3ToAlpha2Map[$alpha3])) {
                if ($alpha3ToAlpha2Map[$alpha3] !== $alpha2) {
                    throw new RuntimeException("Duplicated ISO 639 alpha3 code: {$alpha3}");
                }
            } else {
                $alpha3ToAlpha2Map[$alpha3] = $alpha2;
            }
        }
    }
}
