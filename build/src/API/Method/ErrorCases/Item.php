<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\API\Method\ErrorCases;

class Item
{
    public readonly string $description;
    public readonly string $exceptionClass;

    public function __construct(
        public readonly int $from,
        public readonly int $to,
        string $description,
        public readonly bool $withErrors,
    ) {
        $this->exceptionClass = 'MLocati\\Nexi\\XPayWeb\\Exception\\ErrorResponse' . ($this->withErrors ? '\\Detailed' : '');
        $this->description = preg_replace(
            '/[\\s\\-]*\\b(No Header for this response|No Header and Body for this response)$/i',
            '',
            $description
        );
    }

    public function getThrowsPhpDocLine(): string
    {
        $description = preg_replace(
            '/\\s+/',
            ' ',
            $this->description
        );
        if ($this->from === $this->to) {
            $when = "HTTP code: {$this->from}";
        } else {
            $when = "HTTP code: {$this->from} -> {$this->to}";
        }
        $result = '@throws \\' . $this->exceptionClass;
        if ($description === '') {
            $result .= " {$when}";
        } else {
            $result .= " {$description} ({$when})";
        }

        return $result;
    }
}
