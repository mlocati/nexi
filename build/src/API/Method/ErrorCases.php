<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\API\Method;

class ErrorCases
{
    /**
     * @var \MLocati\Nexi\XPayWeb\Build\API\Method\ErrorCases\Item[]
     */
    public readonly array $items;
    public readonly bool $isSomeItemUsingJson;

    /**
     * @param \MLocati\Nexi\XPayWeb\Build\API\Method\ErrorCases\Item[] $items
     */
    public function __construct(array $items)
    {
        usort($items, static fn (ErrorCases\Item $a, ErrorCases\Item $b): int => $a->from - $b->from);
        $this->items = array_values($items);
        $this->isSomeItemUsingJson = array_filter($this->items, static fn (ErrorCases\Item $item): bool => $item->withErrors) !== [];
    }

    public function toPHP(string $indent): string
    {
        if ($this->items === []) {
            return '[]';
        }
        $lines = [];
        $lines[] = '[';
        foreach ($this->items as $item) {
            if (preg_match('/^[\\w \\-:,.\\/]*$/', $item->description)) {
                $description = "'{$item->description}'";
            } else {
                $description = json_encode($item->description);
            }
            $lines[] = "{$indent}    ['from' => {$item->from}, 'to' => {$item->from}, 'description' => {$description}" . ($item->withErrors ? ", 'detailed' => true" : '') . '],';
        }
        $lines[] = "{$indent}]";

        return implode("\n", $lines);
    }
}
