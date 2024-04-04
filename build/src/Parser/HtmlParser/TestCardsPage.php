<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\Parser\HtmlParser;

use DOMDocument;
use DOMElement;
use MLocati\Nexi\Build\API;
use MLocati\Nexi\Build\Parser\HtmlParser;
use RuntimeException;

class TestCardsPage extends HtmlParser
{
    public const PATH = '/en/area-test/carte-di-pagamento';

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
        $container = $this->getElement($page, '//*[@id="maincontent"]');
        $cards = array_merge($this->getCards($container, true), $this->getCards($container, false));
        $api->setTestCards($see, $cards);
    }

    private function getCards(DOMElement $container, bool $positiveOutcome): array
    {
        $startElement = $this->getStartElement($container, '/^' . ($positiveOutcome ? 'Positive outcome' : 'Negative outcome') . '/i');
        $table = $this->getTableNextTo($container, $startElement);
        $cards = [];
        foreach ($this->listBodyRows($table) as $row) {
            $card = $this->extractCardFromRow($row, $positiveOutcome);
            if ($card === null) {
                throw new RuntimeException("Can't extract card from\n" . $row->ownerDocument->saveHTML($row));
            }
            $cards[] = $card;
        }
        if ($cards === []) {
            throw new RuntimeException("Can't find any card inside\n" . $table->ownerDocument->saveHTML($table));
        }

        return $cards;
    }

    private function getStartElement(DOMElement $container, string $rx): DOMElement
    {
        $result = null;
        foreach ($this->listDescendingElements($container) as $child) {
            if ($child->childElementCount !== 0) {
                continue;
            }
            if (!preg_match($rx, $this->getNormalizedText($child))) {
                continue;
            }
            if ($result !== null) {
                throw new RuntimeException("Found more than one element matching {$rx}");
            }
            $result = $child;
        }
        if ($result === null) {
            throw new RuntimeException("Found no elements matching {$rx}");
        }

        return $result;
    }

    private function getTableNextTo(DOMElement $container, DOMElement $element): DOMElement
    {
        $elementFound = false;
        foreach ($this->listDescendingElements($container) as $child) {
            if ($elementFound === false) {
                $elementFound = $child === $element;
                continue;
            }
            if (strtolower($child->tagName) === 'table') {
                return $child;
            }
        }

        throw new RuntimeException("Can't find a table element next to\n" . $element->ownerDocument->saveHTML($element));
    }

    private function extractCardFromRow(DOMElement $row, bool $positiveOutcome): ?array
    {
        $cell = $row->firstElementChild;
        if ($cell === null || ($circuit = $this->getNormalizedText($cell)) === '') {
            return null;
        }
        $cell = $cell->nextElementSibling;
        if ($cell === null || !preg_match('/^[0-9 \\-]+/', $formattedCardNumber = $this->getNormalizedText($cell))) {
            return null;
        }
        $cell = $cell->nextElementSibling;
        if ($cell === null || !preg_match('_^([01]?[0-9])[ /\\-]([0-9][0-9]([0-9][0-9])?)$_', $expiry = $this->getNormalizedText($cell))) {
            return null;
        }
        [$expiryMonth, $expiryYear] = preg_split('/\\D/', $expiry);
        $expiryMonth = (int) $expiryMonth;
        $expiryYear = (int) $expiryYear;
        $cell = $cell->nextElementSibling;
        if ($cell === null || !preg_match('/^\\d{3}$/', $cvv = $this->getNormalizedText($cell))) {
            return null;
        }
        $cell = $cell->nextElementSibling;
        if ($cell !== null) {
            return null;
        }

        return [
            'positiveOutcome' => $positiveOutcome,
            'circuit' => $circuit,
            'formattedCardNumber' => $formattedCardNumber,
            'expiryMonth' => $expiryMonth,
            'expiryYear' => $expiryYear,
            'cvv' => $cvv,
        ];
    }
}
