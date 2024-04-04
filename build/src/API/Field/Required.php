<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\API\Field;

class Required
{
    public function __construct(
        public readonly bool $required,
        public readonly string $methodName,
        public bool $request = false,
        public bool $response = false,
    ) {
    }

    public function __toString(): string
    {
        $result = $this->required ? '@required' : '@optional';
        if ($this->request !== $this->response) {
            return $result . ($this->request ? ' in request' : ' in response') . ' of ' . $this->methodName;
        }

        return $result . ' for ' . $this->methodName;
    }

    public function mergeInfo(self $other): void
    {
        if ($other->request) {
            $this->request = true;
        }
        if ($other->response) {
            $this->response = true;
        }
    }
}
