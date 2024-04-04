<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build;

use RuntimeException;

class ParserManager
{
    /**
     * @var \MLocati\Nexi\Build\Parser[]
     */
    private array $parsers;

    public function __construct(
        private readonly API $api,
        private readonly UrlReader $urlReader,
    ) {
        $this->parsers = [
            new Parser\HtmlParser\SpecificationsPage(),
            new Parser\HtmlParser\APIPage(),
            new Parser\HtmlParser\EncodingPage(),
            new Parser\HtmlParser\APINotificationPage(),
            new Parser\HtmlParser\ApiKeysPage(),
            new Parser\WPPluginCurrencies(),
        ];
    }

    public function parse(string $url): void
    {
        $path = parse_url($url, PHP_URL_PATH);
        if ($path === false) {
            throw new RuntimeException("Failed to parse URL {$url}");
        }
        $parser = $this->getParser($path);
        if ($parser === null) {
            return;
        }
        $contents = $this->urlReader->get($url);
        $parser->parse($url, $path, $contents, $this->api);
    }

    private function getParser(string $path): ?Parser
    {
        $parsers = array_filter(
            $this->parsers,
            static fn (Parser $parser) => $parser->shouldHandlePath($path)
        );
        switch (count($parsers)) {
            case 0:
                return null;
            case 1:
                return array_shift($parsers);
        }
        throw new RuntimeException("More than one page parser for path {$path}");
    }
}
