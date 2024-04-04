<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\Parser\HtmlParser;

use DOMDocument;
use DOMElement;
use Generator;
use MLocati\Nexi\Build\API;
use MLocati\Nexi\Build\Parser\HtmlParser;
use RuntimeException;

class ApiKeysPage extends HtmlParser
{
    public const PATH = '/en/area-test/api-key';

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
        $mainContent = $this->findMainContent($page);
        $testApiKey = $this->findApiKey($mainContent);
        $api->setApiKeyTest($see, $testApiKey);
    }

    private function findMainContent(DOMDocument $page): DOMElement
    {
        return $this->getElement($page, '//*[@id="maincontent"]');
    }

    private function findApiKey(DOMElement $container): string
    {
        $apiKey = '';
        foreach ($this->listChildElements($container) as $element) {
            $found = $this->findApiKeyIn($element);
            if ($apiKey === '') {
                $apiKey = $found;
            } elseif ($found !== '') {
                throw new RuntimeException('Multiple test API keys found');
            }
        }
        if ($apiKey === '') {
            throw new RuntimeException('Failed to find the test API key');
        }

        return $apiKey;
    }

    /**
     * @return \Generator<\DOMElement>
     */
    private function listChildElements(DOMElement $parent): Generator
    {
        for ($child = $parent->firstElementChild; $child !== null; $child = $child->nextElementSibling) {
            yield $child;
            foreach ($this->listChildElements($child) as $grandChild) {
                yield $grandChild;
            }
        }
    }

    private function findApiKeyIn(DOMElement $element): string
    {
        $text = $this->getNormalizedText($element);
        $match = null;
        if (preg_match('/^Api-Key implicit accounting terminal \\S+: (?<key>\\S+)$/i', $text, $match)) {
            return $match['key'];
        }

        return '';
    }
}
