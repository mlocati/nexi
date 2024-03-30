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
                $api->setLanguages($this->extractLanguages($page));
                break;
            case '/en/altro-/codifiche/codici-errore':
                $api->setErrorCodes($this->extractErrorCodes($page));
                break;
            case '/en/altro-/codifiche/elenco-valute':
                $api->setCurrencies($this->extractCurrencies($page));
                break;
            case '/en/altro-/codifiche/codifica-paymentservice':
                $api->setPaymentServices($this->extractPaymentServices($page));
                break;
            case '/en/altro-/codifiche/Response-Code-ISO':
                $api->setISO8583ResponseCodes($this->extractISO8583ResponseCodes($page));
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
