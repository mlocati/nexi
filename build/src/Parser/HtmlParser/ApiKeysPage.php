<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\Parser\HtmlParser;

use DOMDocument;
use DOMElement;
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
        $apiTestParameters = $this->findApiTestParameters($mainContent);
        $api->setApiTestParameters($see, $apiTestParameters);
    }

    private function findMainContent(DOMDocument $page): DOMElement
    {
        return $this->getElement($page, '//*[@id="maincontent"]');
    }

    private function findApiTestParameters(DOMElement $container): array
    {
        $kinds = ['IMPLICIT', 'EXPLICIT'];
        $testData = [];
        foreach ($this->listDescendingElements($container) as $element) {
            foreach ($kinds as $kind) {
                $found = $this->findApiTestParametersIn($element, $kind);
                if ($found === null) {
                    continue;
                }
                if (isset($testData[$kind])) {
                    if ($testData[$kind] !== $found) {
                        throw new RuntimeException("Multiple {$kind} API test data found");
                    }
                } else {
                    $testData[$kind] = $found;
                }
            }
        }
        foreach ($kinds as $kind) {
            if (!isset($testData[$kind])) {
                throw new RuntimeException("Failed to find the {$kind} API test data");
            }
        }

        return $testData;
    }

    private function findApiTestParametersIn(DOMElement $element, string $kind): ?array
    {
        switch ($kind) {
            case 'IMPLICIT':
                $kindText = 'implicit';
                break;
            case 'EXPLICIT':
                $kindText = 'explicit';
                break;
            default:
                return null;
        }
        $text = $this->getNormalizedText($element);
        $match = null;
        if (!preg_match('/^Api-Key ' . $kindText . ' accounting terminal (?<terminalId>\\d+): (?<apiKey>\\S+)$/i', $text, $match)) {
            return null;
        }

        return ['terminalId' => $match['terminalId'], 'apiKey' => $match['apiKey']];
    }
}
