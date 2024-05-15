<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Dictionary;

use ReflectionClass;
use RuntimeException;

/* <<TOPCOMMENT>> */

/* <<CLASS_PHPDOC>> */
class Currency
{
    /* <<IDS>> */

    /* <<MOVE_DECIMALS_DOC>> */
    const MOVE_DECIMALS = [
        /* <<MOVE_DECIMALS>> */
    ];

    /**
     * @return string[]
     */
    public function getAvailableIDs(): array
    {
        $result = [];
        $class = new ReflectionClass($this);
        foreach ($class->getConstants() as $name => $value) {
            if (strpos($name, 'ID_') === 0 && is_string($value)) {
                $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * @param float|int|string $amount
     *
     * @throws \RuntimeException if $amount or $currency are not valid
     */
    public function formatDecimals($amount, string $currency): int
    {
        $map = $this::MOVE_DECIMALS;
        if (!isset($map[$currency])) {
            throw new RuntimeException('The currency is not valid');
        }

        return $this->moveDecimals($amount, $map[$currency]);
    }

    /**
     * @param float|int|string $amount
     *
     * @throws \RuntimeException if $amount or $currency are not valid
     */
    public function moveDecimals($amount, int $moveDecimals): int
    {
        if (!is_numeric($amount)) {
            throw new RuntimeException('The amount is not numeric');
        }
        if ($moveDecimals < 0) {
            throw new RuntimeException('The number of decimals to be rounded is not valid');
        }
        $amount = ltrim(rtrim((string) $amount, '.'), '+');
        if ($amount[0] === '-') {
            $sign = -1;
            $amount = substr($amount, 1);
        } else {
            $sign = 1;
        }

        return $sign * $this->doMoveDecimals($amount, $moveDecimals);
    }

    /**
     * @param string $amount a string containing a non-negative number
     */
    private function doMoveDecimals(string $amount, int $moveDecimals): int
    {
        $dotPosition = strpos($amount, '.');
        if ($moveDecimals === 0) {
            if ($dotPosition === false) {
                return (int) $amount;
            }

            return (int) round((float) $amount);
        }
        if ($dotPosition === false) {
            return (int) ($amount . str_repeat('0', $moveDecimals));
        }
        if ($dotPosition === 0) {
            $amount = '0' . $amount;
            $dotPosition++;
        }
        $amount = str_replace('.', '', $amount);
        $numDecimals = strlen($amount) - $dotPosition;
        $delta = $moveDecimals - $numDecimals;
        if ($delta === 0) {
            return (int) $amount;
        }
        if ($delta > 0) {
            return (int) ($amount . str_repeat('0', $delta));
        }
        $amount = round((int) $amount, $delta);

        return (int) substr((string) $amount, 0, $delta);
    }
}
