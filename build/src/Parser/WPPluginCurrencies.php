<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\Parser;

use MLocati\Nexi\XPayWeb\Build\API;
use MLocati\Nexi\XPayWeb\Build\Parser;
use RuntimeException;

class WPPluginCurrencies implements Parser
{
    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\XPayWeb\Build\Parser::shouldHandlePath()
     */
    public function shouldHandlePath(string $path): bool
    {
        return str_contains($path, '/WC_Gateway_NPG_Currency.php');
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\XPayWeb\Build\Parser::parse()
     */
    public function parse(string $see, string $path, string $contents, API $api): void
    {
        $tokens = array_values(array_filter(
            token_get_all($contents),
            static fn (string|array $token): bool => is_string($token) || !in_array($token[0], [T_WHITESPACE, T_DOC_COMMENT | T_COMMENT], true),
        ));
        $classRange = $this->getClassRange($tokens);
        $dictionary = null;
        for ($offset = $classRange[0]; $offset < $classRange[1];) {
            $arrayRange = $this->findArrayRange($tokens, $offset, $classRange[1]);
            if ($arrayRange === null) {
                break;
            }
            $thisDictionary = $this->extractDictionaryFromArray($tokens, $arrayRange[0], $arrayRange[1]);
            if ($thisDictionary !== null) {
                if ($dictionary !== null) {
                    throw new RuntimeException('More than one dictionary found');
                }
                $dictionary = $thisDictionary;
            }
            $offset = $arrayRange[0] + 1;
        }
        if ($dictionary === null) {
            throw new RuntimeException('Dictionary not found');
        }
        ksort($dictionary, SORT_STRING);
        $api->setCurrencyDecimals($see, $dictionary);
    }

    private function getClassRange(array $tokens): array
    {
        $depth = null;
        $start = null;
        $end = null;
        foreach ($tokens as $index => $token) {
            if (is_array($token) && $token[0] === T_CLASS) {
                if ($depth !== null) {
                    throw new RuntimeException('More than one class found');
                }
                $depth = 0;
                continue;
            }
            if ($depth === null) {
                continue;
            }
            if ($token === '{') {
                if ($depth === 0) {
                    if ($start !== null) {
                        throw new RuntimeException('More than one root code block found');
                    }
                    $start = $index + 1;
                }
                $depth++;
            } elseif ($token === '}') {
                if ($depth === 0) {
                    throw new RuntimeException('Unmatched closing parenthesis found');
                }
                if ($depth === 1) {
                    if ($end !== null) {
                        throw new RuntimeException('More than one root code block found');
                    }
                    $end = $index - 1;
                }
                $depth--;
            }
        }
        if ($depth === null) {
            throw new RuntimeException('Class found');
        }
        if ($depth !== 0) {
            throw new RuntimeException('Unmatched opening parenthesis found');
        }

        return [$start, $end];
    }

    private function findArrayRange(array $tokens, int $offset, int $maxIndex): ?array
    {
        $depth = 0;
        $start = null;
        $expectedArrayEnds = [];
        for ($index = $offset; $index < $maxIndex - 1; $index++) {
            $token = $tokens[$index];
            $isArrayStart = false;
            if (is_array($token) && $token[0] === T_ARRAY && $tokens[$index + 1] === '(') {
                $index++;
                $expectedArrayEnds[] = ')';
                $isArrayStart = true;
            } elseif ($token === '[') {
                $expectedArrayEnds[] = ']';
                $isArrayStart = true;
            } else {
                $isArrayStart = false;
            }
            if ($isArrayStart) {
                if ($depth === 0) {
                    $start = $index + 1;
                }
                $depth++;
                continue;
            }
            if ($depth === 0) {
                continue;
            }
            if ($token === $expectedArrayEnds[count($expectedArrayEnds) - 1]) {
                array_pop($expectedArrayEnds);
                $depth--;
                if ($depth === 0) {
                    return [$start, $index - 1];
                }
            }
        }

        return null;
    }

    private function extractDictionaryFromArray(array $tokens, int $start, int $end): ?array
    {
        $result = [];
        for ($index = $start; $index < $end - 1; $index += 4) {
            $key = $tokens[$index];
            if (!is_array($key) || $key[0] !== T_CONSTANT_ENCAPSED_STRING) {
                return null;
            }
            if (!preg_match('/^["\'][A-Z]{3}["\']$/', $key[1])) {
                return null;
            }
            $arrow = $tokens[$index + 1];
            if (!is_array($arrow) || $arrow[0] !== T_DOUBLE_ARROW) {
                return null;
            }
            $value = $tokens[$index + 2];
            if (!is_array($value) || $value[0] !== T_LNUMBER) {
                return null;
            }
            if (!preg_match('/^\\d+$/', $value[1])) {
                return null;
            }
            if ($index + 2 < $end) {
                $comma = $tokens[$index + 3];
                if ($comma !== ',') {
                    return null;
                }
            }
            $result[substr($key[1], 1, -1)] = (int) $value[1];
        }

        return $result === [] ? null : $result;
    }
}
