<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\Parser\HtmlParser;

use Closure;
use DOMDocument;
use MLocati\Nexi\Build\API;
use MLocati\Nexi\Build\Parser\HtmlParser;
use RuntimeException;

class EncodingPage extends HtmlParser
{
    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Build\Parser::shouldHandlePath()
     */
    public function shouldHandlePath(string $path): bool
    {
        return str_starts_with($path, '/en/altro-/codifiche/');
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Build\Parser\HtmlParser::parseDoc()
     */
    public function parseDoc(string $see, string $path, DOMDocument $page, API $api): void
    {
        switch ($path) {
            case '/en/altro-/codifiche/codifica-language':
                $alpha3ToAlpha2 = $api->getISO639Alpha3ToAlpha2Map();
                if ($alpha3ToAlpha2 === []) {
                    throw new RuntimeException('The ISO-639 alpha3 to alpha2 map is empty');
                }
                $dictionary = $this->extractLanguages($page);
                $nexiToAlpha2 = $this->buildLanguageNexiToAlpha2Map($dictionary, $alpha3ToAlpha2);
                $alpha2ToNexi = $this->buildLanguageAlpha2ToNexiMap($dictionary, $alpha3ToAlpha2);
                $api->setLanguages($see, [
                    'dictionary' => $dictionary,
                    'nexiToAlpha2' => $nexiToAlpha2,
                    'alpha2ToNexi' => $alpha2ToNexi,
                ]);
                break;
            case '/en/altro-/codifiche/codici-errore':
                $api->setErrorCodes($see, $this->extractErrorCodes($page));
                break;
            case '/en/altro-/codifiche/elenco-valute':
                $api->setCurrencies($see, $this->extractCurrencies($page));
                break;
            case '/en/altro-/codifiche/codifica-paymentservice':
                $api->setPaymentServices($see, $this->extractPaymentServices($page));
                break;
            case '/en/altro-/codifiche/Response-Code-ISO':
                $api->setISO8583ResponseCodes($see, $this->extractISO8583ResponseCodes($page));
                break;
            default:
                throw new RuntimeException("Unrecognized dictionary page: {$path}");
        }
    }

    private function extractLanguages(DOMDocument $page): array
    {
        return $this->extractDictionary(
            $page,
            static fn ($code): bool => preg_match('/^[a-z]{3}$/i', $code) === 1
        );
    }

    private function buildLanguageNexiToAlpha2Map(array $languages, array $alpha3ToAlpha2Map): array
    {
        $nexiToAplha2 = [];
        foreach (array_keys($languages) as $nexi) {
            $alpha2 = $alpha3ToAlpha2Map[$nexi] ?? '';
            if (empty($alpha2)) {
                throw new RuntimeException("The Nexi language code {$nexi} is not recognized");
            }
            $nexiToAplha2[$nexi] = $alpha2;
        }

        return $nexiToAplha2;
    }

    private function buildLanguageAlpha2ToNexiMap(array $languages, array $alpha3ToAlpha2Map): array
    {
        $alpha2ToNexi = [];
        foreach (array_keys($languages) as $nexi) {
            $alpha2 = $alpha3ToAlpha2Map[$nexi] ?? '';
            if (empty($alpha2)) {
                throw new RuntimeException("The Nexi language code {$nexi} is not recognized");
            }
            if (($alpha2ToNexi[$alpha2] ?? $nexi) !== $nexi) {
                throw new RuntimeException("The Nexi language code {$nexi} has multiple alpha2 values");
            }
            $alpha2ToNexi[$alpha2] = $nexi;
        }

        return $alpha2ToNexi;
    }

    private function extractErrorCodes(DOMDocument $page): array
    {
        return $this->extractDictionary(
            $page,
            static fn ($code): bool => preg_match('/^PS\\d+$/', $code) === 1,
            ignoreDuplicates: true
        );
    }

    private function extractCurrencies(DOMDocument $page): array
    {
        return $this->extractDictionary(
            $page,
            static fn ($code): bool => preg_match('/^[A-Z]{3}$/', $code) === 1,
            ignoreThirdColumn: true
        );
    }

    private function extractPaymentServices(DOMDocument $page): array
    {
        return $this->extractDictionary(
            $page,
            static fn ($code): bool => preg_match('/^\\w+$/', $code) === 1,
        );
    }

    private function extractISO8583ResponseCodes(DOMDocument $page): array
    {
        return $this->extractDictionary(
            $page,
            static fn ($code): bool => preg_match('/^\\d{3}$/', $code) === 1,
        );
    }

    private function extractDictionary(DOMDocument $page, Closure $codeChecker, bool $ignoreDuplicates = false, bool $ignoreThirdColumn = false): array
    {
        $main = $this->getElement($page, "descendant::div[@id='maincontent-wrapper']");
        $table = $this->getElement($main, 'descendant::table');
        $result = [];
        foreach ($this->listBodyRows($table) as $row) {
            $code = '';
            $name = '';
            $numCells = $row->childElementCount;
            if ($numCells === 3 && $ignoreThirdColumn) {
                $numCells = 2;
            }
            if ($numCells === 2) {
                $cell = $row->firstElementChild;
                $code = $this->getNormalizedText($cell);
                $cell = $cell->nextElementSibling;
                $name = $this->getNormalizedText($cell);
            }
            if ($code === '' || $name === '' || $codeChecker($code) !== true) {
                $html = $row->ownerDocument->saveHTML($row);
                throw new RuntimeException("Invalid language row:\n{$html}");
            }
            if (isset($result[$code])) {
                if ($ignoreDuplicates === false) {
                    throw new RuntimeException("Duplicated languace code: {$code}");
                }
            } else {
                $result[$code] = $name;
            }
        }
        ksort($result, SORT_STRING);

        return $result;
    }
}
