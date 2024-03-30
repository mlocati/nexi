<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build;

use DOMXPath;
use RuntimeException;

class LinkProvider
{
    use DOMLoader;

    public function __construct(
        private readonly UrlReader $urlReader,
    ) {
    }

    public function getUrls(string $url, array $urlPrefixAllowList): array
    {
        $html = $this->urlReader->get($url);
        $doc = $this->createDOMDocument($html);
        [$baseUrlAbs, $baseUrlRel] = $this->buildUrlPrefixes($url);
        $xpath = new DOMXPath($doc);
        $anchors = $xpath->evaluate('//a[@href]');
        $result = [];
        foreach ($anchors as $anchor) {
            $rawLink = (string) $anchor->getAttribute('href');
            if ($rawLink === '') {
                continue;
            }
            $absoluteLink = $this->absolutize($rawLink, $baseUrlAbs, $baseUrlRel);
            if (!in_array($absoluteLink, $result, true)) {
                foreach ($urlPrefixAllowList as $urlPrefix) {
                    if (strpos($absoluteLink, $urlPrefix) === 0) {
                        $result[] = $absoluteLink;
                        break;
                    }
                }
            }
        }

        return $result;
    }

    private function absolutize(string $link, string $baseUrlAbs, string $baseUrlRel): string
    {
        $info = parse_url($link);
        if ($info === false) {
            throw new RuntimeException("Failed to parse link {$link}");
        }
        if (!empty($info['scheme']) || !empty($info['host'])) {
            if (empty($info['scheme']) || empty($info['host'])) {
                throw new RuntimeException("Failed to parse link {$link}");
            }

            return $link;
        }

        return $link[0] === '/' ? "{$baseUrlAbs}{$link}" : "{$baseUrlRel}{$link}";
    }

    private function buildUrlPrefixes(string $url): array
    {
        $info = parse_url($url);
        if ($info === false) {
            throw new RuntimeException("Failed to parse URL {$url}");
        }
        $baseUrlAbs = "{$info['scheme']}://{$info['host']}";
        if (!empty($info['port'])) {
            $baseUrlAbs .= ":{$info['port']}";
        }
        $baseUrlRel = $baseUrlAbs . '/';
        $path = trim($info['path'] ?? '', '/');
        if ($path !== '') {
            $baseUrlRel .= "{$path}/";
        }

        return [$baseUrlAbs, $baseUrlRel];
    }
}
