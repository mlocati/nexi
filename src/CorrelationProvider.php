<?php

declare(strict_types=1);

namespace MLocati\Nexi;

interface CorrelationProvider
{
    /**
     * Get the value of the Correlation-Id header that uniquely identify a request.
     */
    public function getCorrelationID(): string;
}
