<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Dictionary\TestCard;

class Card
{
    /**
     * @var bool
     */
    private $positiveOutcome;

    /**
     * @var string
     */
    private $circuit;

    /**
     * @var string
     */
    private $formattedCardNumber;

    /**
     * @var int
     */
    private $expiryMonth;

    /**
     * @var int
     */
    private $expiryYear;

    /**
     * @var string
     */
    private $cvv;

    public function __construct(bool $positiveOutcome, string $circuit, string $formattedCardNumber, int $expiryMonth, int $expiryYear, string $cvv)
    {
        $this->positiveOutcome = $positiveOutcome;
        $this->circuit = $circuit;
        $this->formattedCardNumber = $formattedCardNumber;
        $this->expiryMonth = $expiryMonth;
        $this->expiryYear = $expiryYear;
        $this->cvv = $cvv;
    }

    public function isPositiveOutcome(): bool
    {
        return $this->positiveOutcome;
    }

    public function getCircuit(): string
    {
        return $this->circuit;
    }

    public function getCardNumber(): string
    {
        return strtr($this->getFormattedCardNumber(), [' ' => '', '-' => '']);
    }

    public function getFormattedCardNumber(): string
    {
        return $this->formattedCardNumber;
    }

    public function getExpiryMonth(): int
    {
        return $this->expiryMonth;
    }

    public function getExpiryYear(): int
    {
        return $this->expiryYear;
    }

    public function getExpiry(): string
    {
        return implode('/', [
            str_pad((string) $this->expiryMonth, 2, '0', STR_PAD_LEFT),
            str_pad((string) $this->expiryYear, $this->expiryYear >= 100 ? 4 : 2, '0', STR_PAD_LEFT),
        ]);
    }

    public function getCvv(): string
    {
        return $this->cvv;
    }

}
