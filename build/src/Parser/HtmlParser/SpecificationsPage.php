<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\Parser\HtmlParser;

use DOMDocument;
use DOMElement;
use MLocati\Nexi\Build\API;
use MLocati\Nexi\Build\Parser\HtmlParser;
use RuntimeException;

class SpecificationsPage extends HtmlParser
{
    public const PATH = '/en/api/specifiche-di-utilizzo-del-servizio';

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Build\Parser::shouldHandlePath()
     */
    public function shouldHandlePath(string $path): bool
    {
        return $path === self::PATH;
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Build\Parser\HtmlParser::parseDoc()
     */
    public function parseDoc(string $see, string $path, DOMDocument $page, API $api): void
    {
        $table = $this->findTableWithUrls($page);
        $baseUrlProduction = $this->findUrl($table, 'Production url');
        if ($api->baseUrlProduction === '' || $api->baseUrlProduction === $baseUrlProduction) {
            $api->baseUrlProduction = $baseUrlProduction;
        } else {
            throw new RuntimeException("More than one production URLS:\n{$api->baseUrlProduction}\n{$baseUrlProduction}");
        }
        $baseUrlTest = $this->findUrl($table, 'Test url');
        if ($api->baseUrlTest === '' || $api->baseUrlProduction === $baseUrlTest) {
            $api->baseUrlTest = $baseUrlTest;
        } else {
            throw new RuntimeException("More than one production URLS:\n{$api->baseUrlTest}\n{$baseUrlTest}");
        }
    }

    private function findTableWithUrls(DOMDocument $page): DOMElement
    {
        $result = null;
        foreach ($this->findElements($page, '//table[@class]') as $table) {
            if ($table->getAttribute('class') !== 'elenco-specifiche') {
                continue;
            }
            $text = $this->getNormalizedText($table);
            if (stripos($text, 'Production url') !== false || stripos($text, 'Test url') !== false) {
                if ($result !== null) {
                    throw new RuntimeException('More than one relevant table found');
                }
                $result = $table;
            }
        }
        if ($result === null) {
            throw new RuntimeException('No relevant tables found');
        }

        return $result;
    }

    private function findUrl(DOMElement $table, string $headerText): string
    {
        $result = '';
        $rows = $this->findElements($table, './/tr');
        foreach ($rows as $row) {
            $cell = $row->firstElementChild;
            if (!$cell instanceof DOMElement) {
                continue;
            }
            $text = $this->getNormalizedText($cell);
            if (strcasecmp($text, $headerText) !== 0) {
                continue;
            }
            $cell = $cell->nextElementSibling;
            if (!$cell instanceof DOMElement) {
                continue;
            }
            $url = $this->getNormalizedText($cell);
            if ($url === '') {
                throw new RuntimeException("Empty URL matching {$headerText}");
            }
            if ($result === '' || $result === $url) {
                $result = $url;
            } else {
                throw new RuntimeException("More than one URL matching {$headerText}");
            }
        }
        if ($result === '') {
            throw new RuntimeException("No URLs matching {$headerText}");
        }

        return $result;
    }
}
