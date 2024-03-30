<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build;

interface Parser
{
    public function shouldHandlePath(string $path): bool;

    public function parse(string $see, string $path, string $contents, API $api): void;
}
