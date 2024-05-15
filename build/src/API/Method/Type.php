<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\API\Method;

use MLocati\Nexi\XPayWeb\Build\API\Entity;

class Type
{
    public function __construct(
        public readonly Entity $entity,
        public readonly bool $isArrayOf
    ) {
    }
}
