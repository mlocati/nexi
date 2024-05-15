<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build;

use DOMDocument;
use RuntimeException;

trait DOMLoader
{
    protected function createDOMDocument(string $html): DOMDocument
    {
        $doc = new DOMDocument();
        set_error_handler(static function (): void {}, -1);
        try {
            $loaded = $doc->loadHTML($html, LIBXML_NONET | LIBXML_NOWARNING);
        } finally {
            restore_error_handler();
        }
        if (!$loaded) {
            throw new RuntimeException('Failed to load HTML');
        }

        return $doc;
    }
}
