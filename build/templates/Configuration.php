<?php

declare(strict_types=1);

namespace MLocati\Nexi;

/* <<TOPCOMMENT>> */

interface Configuration
{
    /* <<TEST_URL_PHPDOC>> */
    const DEFAULT_BASEURL_TEST = '/* <<TEST_URL>> */';

    /* <<PRODUCTION_URL_PHPDOC>> */
    const DEFAULT_BASEURL_PRODUCTION = '/* <<PRODUCTION_URL>> */';

    /* <<TEST_APIKEY_PHPDOC>> */
    const DEFAULT_APIKEY_TEST = '/* <<TEST_APIKEY>> */';

    /**
     * Get the API key.
     */
    public function getBaseUrl(): string;

    /**
     * Get the API key.
     */
    public function getApiKey(): string;

    /**
     * Allow unsafe HTTPS connections.
     * Use with caution!
     */
    public function allowUnsafeHttps(): bool;
}
