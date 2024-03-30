<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\Parser;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Generator;
use MLocati\Nexi\Build\API;
use MLocati\Nexi\Build\DOMLoader;
use MLocati\Nexi\Build\Parser;
use RuntimeException;

abstract class HtmlParser implements Parser
{
    use DOMLoader;

    private ?DOMXPath $xpath = null;

    abstract public function parseDoc(string $see, string $path, DOMDocument $page, API $api): void;

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Build\Parser::parse()
     */
    public function parse(string $see, string $path, string $contents, API $api): void
    {
        $page = $this->createDOMDocument($contents);
        $this->parseDoc($see, $path, $page, $api);
    }

    /**
     * @return \DOMElement[]
     */
    protected function findElements(DOMNode $parent, string $query): array
    {
        $result = [];
        $xpath = $this->getXPath($parent);
        $context = $parent instanceof DOMDocument ? null : $parent;

        foreach ($xpath->query($query, $context) as $node) {
            if ($node instanceof DOMElement) {
                if (!in_array($node, $result, true)) {
                    $result[] = $node;
                }
            }
        }

        return $result;
    }

    protected function findElement(DOMNode $parent, string $query): ?DOMElement
    {
        $elements = $this->findElements($parent, $query);
        $count = count($elements);
        switch ($count) {
            case 0:
                return null;
            case 1:
                return $elements[0];
            default:
                throw new RuntimeException("Too many elements matching {$query} (expected: 1, found: {$count})");
        }
    }

    protected function getElement(DOMNode $parent, string $query): DOMElement
    {
        $element = $this->findElement($parent, $query);
        if ($element === null) {
            throw new RuntimeException("No elements found matching {$query}");
        }

        return $element;
    }

    protected function getNormalizedText(DOMElement $element): string
    {
        $text = str_replace("\r", "\n", str_replace("\r\n", "\n", (string) $element->textContent));
        $text = strtr($text, [
            // ZERO WIDTH SPACE
            "\u{A0}" => ' ',
            // ZERO WIDTH SPACE
            "\u{200B}" => '',
        ]);
        $lines = [];
        foreach (explode("\n", $text) as $line) {
            $line = trim(preg_replace('/\\s+/', ' ', $line));
            if ($line !== '') {
                $lines[] = $line;
            }
        }

        return implode("\n", $lines);
    }

    protected function listBodyRows(DOMElement $container): Generator
    {
        for ($child = $container->firstElementChild; $child !== null; $child = $child->nextElementSibling) {
            switch (strtolower($child->tagName)) {
                case 'thead':
                    break;
                case 'tbody':
                    foreach ($this->listBodyRows($child) as $row) {
                        yield $row;
                    }
                    break;
                case 'tr':
                    yield $child;
                    break;
            }
        }
    }

    private function getXPath(DOMNode $parent): DOMXPath
    {
        $doc = $parent instanceof DOMDocument ? $parent : $parent->ownerDocument;
        if ($this->xpath === null || $this->xpath->document !== $doc) {
            $this->xpath = new DOMXPath($doc);
        }

        return $this->xpath;
    }
}
