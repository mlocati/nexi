<?php

declare(strict_types=1);

namespace MLocati\Nexi\Service;

interface QueryEntityInterface
{
    public function getQuerystring(): string;
}
