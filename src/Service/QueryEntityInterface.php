<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Service;

interface QueryEntityInterface
{
    public function getQuerystring(): string;
}
