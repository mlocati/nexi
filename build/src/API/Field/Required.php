<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\API\Field;

use MLocati\Nexi\Build\API\Method\Definition;
use RuntimeException;

class Required
{
    private array $byWhen = [];

    public function __construct(
        public readonly string $methodName,
        Required\When $when,
        bool $required,
    ) {
        $this->byWhen[$when->value] = $required;
    }

    public function __toString(): string
    {
        throw new \RuntimeException('NO!');
    }

    public function merge(self $other): void
    {
        if ($this->methodName !== $other->methodName) {
            throw new RuntimeException('Incompatible Required instances');
        }
        foreach ($other->byWhen as $when => $required) {
            if (isset($this->byWhen[$when])) {
                if ($this->byWhen[$when] !== $required) {
                    throw new RuntimeException('Incompatible Required instances');
                }
            } else {
                $this->byWhen[$when] = $required;
            }
        }
    }

    public function isAlwaysRequired(): bool
    {
        return in_array(true, $this->byWhen, true) && !in_array(false, $this->byWhen, true);
    }

    public function isAlwaysOptional(): bool
    {
        return in_array(false, $this->byWhen, true) && !in_array(true, $this->byWhen, true);
    }

    public function getRequiredPHPDocLine(): string
    {
        if ($this->isAlwaysOptional()) {
            return '';
        }
        if ($this->isAlwaysRequired()) {
            if ($this->methodName === Definition::WEBHOOK_REQUEST) {
                return '@required in the data received in the webhook';
            }
            if ($this->methodName === Definition::WEBHOOK_RESPONSE) {
                return '@required in the data sent in the webhook response';
            }

            return "@required in the {$this->methodName} method";
        }
        $when = Required\When::from(array_search(true, $this->byWhen, true));
        switch ($when) {
            case Required\When::Sending:
                return "@required in the request performed by the {$this->methodName} method";
            case Required\When::Receiving:
                return "@required in the response of the {$this->methodName} method";
        }
    }

    public function getRequiredSpecLine(): string
    {
        if ($this->isAlwaysOptional()) {
            return '';
        }
        if ($this->isAlwaysRequired()) {
            return "'{$this->methodName}' => true";
        }
        $when = Required\When::from(array_search(true, $this->byWhen, true));

        return "'{$this->methodName}' => '{$when->value}'";
    }
}
