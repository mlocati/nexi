<?php

declare(strict_types=1);

namespace MLocati\Nexi\Test\Cases;

use MLocati\Nexi\Dictionary\TestCard;
use MLocati\Nexi\Dictionary\TestCard\Card;
use PHPUnit\Framework\TestCase;

class TestCardTest extends TestCase
{
    public function testCloning(): void
    {
        $instance = new TestCard();
        $allCards = $instance->getCards();
        $this->assertIsArray($allCards);
        $this->assertNotSame([], $allCards);
        $goodCards = $instance->getCards(true);
        $this->assertIsArray($goodCards);
        $this->assertNotSame([], $goodCards);
        $badCards = $instance->getCards(false);
        $this->assertIsArray($badCards);
        $this->assertNotSame([], $badCards);
        foreach ($goodCards as $card) {
            $this->assertNotContains($card, $badCards);
        }
        foreach ($badCards as $card) {
            $this->assertNotContains($card, $goodCards);
        }
        $goodAndBadCards = array_merge($goodCards, $badCards);
        $sorter = static function (Card $a, Card $b): int {
            return strcmp(spl_object_hash($a), spl_object_hash($b));
        };
        usort($allCards, $sorter);
        usort($goodAndBadCards, $sorter);
        $this->assertSame($allCards, $goodAndBadCards);
        $goodCard = $instance->getSampleCard(true);
        $this->assertInstanceOf(Card::class, $goodCard);
        $this->assertTrue($goodCard->isPositiveOutcome());
        $badCard = $instance->getSampleCard(false);
        $this->assertInstanceOf(Card::class, $badCard);
        $this->assertFalse($badCard->isPositiveOutcome());
        foreach ($allCards as $card) {
            $this->assertIsBool($card->isPositiveOutcome());
            $this->assertIsString($card->getCircuit());
            $this->assertNotSame('', $card->getCircuit());
            $this->assertIsString($card->getCardNumber());
            $this->assertNotSame('', $card->getCardNumber());
            $this->assertIsString($card->getFormattedCardNumber());
            $this->assertNotSame('', $card->getFormattedCardNumber());
            $this->assertIsInt($card->getExpiryMonth());
            $this->assertGreaterThanOrEqual(1, $card->getExpiryMonth());
            $this->assertLessThanOrEqual(12, $card->getExpiryMonth());
            $this->assertIsInt($card->getExpiryYear());
            $this->assertGreaterThan(0, $card->getExpiryYear());
            $this->assertStringContainsString((string) $card->getExpiryMonth(), $card->getExpiry());
            $this->assertStringContainsString((string) $card->getExpiryYear(), $card->getExpiry());
            $this->assertRegExp('_^\\d\\d/(\\d\\d)?\\d\\d$_', $card->getExpiry());
        }
    }
}
