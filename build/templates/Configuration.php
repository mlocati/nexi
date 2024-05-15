<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb;

/* <<TOPCOMMENT>> */

interface Configuration
{
    /* <<TEST_URL_PHPDOC>> */
    const DEFAULT_BASEURL_TEST = '/* <<TEST_URL>> */';

    /* <<PRODUCTION_URL_PHPDOC>> */
    const DEFAULT_BASEURL_PRODUCTION = '/* <<PRODUCTION_URL>> */';

    /* <<TEST_APIKEY_IMPLICIT_PHPDOC>> */
    const DEFAULT_APIKEY_IMPLICIT_TEST = '/* <<TEST_APIKEY_IMPLICIT>> */';

    /* <<TEST_TERMINALID_IMPLICIT_PHPDOC>> */
    const DEFAULT_TERMINALID_IMPLICIT_TEST = '/* <<TEST_TERMINALID_IMPLICIT>> */';

    /* <<TEST_APIKEY_EXPLICIT_PHPDOC>> */
    const DEFAULT_APIKEY_EXPLICIT_TEST = '/* <<TEST_APIKEY_EXPLICIT>> */';

    /* <<TEST_TERMINALID_EXPLICIT_PHPDOC>> */
    const DEFAULT_TERMINALID_EXPLICIT_TEST = '/* <<TEST_TERMINALID_EXPLICIT>> */';

    /**
     * This is an API key you can use for tests.
     *
     * @var string
     */
    const DEFAULT_APIKEY_TEST = self::DEFAULT_APIKEY_IMPLICIT_TEST;

    /**
     * Get the API key.
     */
    public function getBaseUrl(): string;

    /**
     * Get the API key.
     */
    public function getApiKey(): string;
}
