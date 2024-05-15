<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build;

use RuntimeException;

class UrlReader
{
    private readonly string $cacheDir;
    private mixed $context = null;

    public function __construct(string $cacheDir)
    {
        if (!is_dir($cacheDir) && !mkdir($cacheDir, 0777, true)) {
            throw new RuntimeException("Failed to create directory {$cacheDir}");
        }
        $this->cacheDir = str_replace(DIRECTORY_SEPARATOR, '/', realpath($cacheDir));
    }

    public function get(string $url): string
    {
        $hash = sha1($url);
        $cacheFilePrefix = "{$this->cacheDir}/{$hash}";
        if (is_file("{$cacheFilePrefix}.txt")) {
            $cachedUrl = file_get_contents("{$cacheFilePrefix}.url");
            if ($cachedUrl === false) {
                throw new RuntimeException("Failed to load file {$cacheFilePrefix}.url}");
            }
            if ($cachedUrl !== $url) {
                throw new RuntimeException("Hash clash for\n{$url}\nvs\n{$cachedUrl}");
            }
            $contents = file_get_contents("{$cacheFilePrefix}.txt");
            if ($contents === false) {
                throw new RuntimeException("Failed to load file {$cacheFilePrefix}.txt}");
            }
        } else {
            $contents = file_get_contents($url, false, $this->getContext());
            if ($contents === false) {
                throw new RuntimeException("Failed to fetch URL {$url}");
            }
            if (file_put_contents("{$cacheFilePrefix}.url", $url) === false) {
                throw new RuntimeException("Failed to save file {$cacheFilePrefix}.url}");
            }
            if (file_put_contents("{$cacheFilePrefix}.txt", $contents) === false) {
                throw new RuntimeException("Failed to save file {$cacheFilePrefix}.txt}");
            }
        }

        return $contents;
    }

    private function getContext(): mixed
    {
        if ($this->context === null) {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => [
                        'Accept: */*',
                        'Cache-Control: no-cache',
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:124.0) Gecko/20100101 Firefox/124.0',
                    ],
                    'follow_location' => 1,
                    'ignore_errors' => false,
                ],
            ]);
            $this->context = $context;
        }

        return $this->context;
    }
}
