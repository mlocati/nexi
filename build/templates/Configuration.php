<?php

declare(strict_types=1);

namespace MLocati\Nexi;

/* <<TOPCOMMENT>> */

interface Configuration
{
    /**
     * This is the default URL to be used for tests.
     *
     * @var string
     */
    const DEFAULT_BASEURL_TEST = '/* <<TEST_URL>> */';

    /**
     * This is the default URL to be used in production.
     *
     * @var string
     */
    const DEFAULT_BASEURL_PRODUCTION = '/* <<PRODUCTION_URL>> */';

    /**
     * Get the API key.
     */
    public function getBaseURL(): string;

    /**
     * Get the API key.
     */
    public function getApiKey(): string;
}
