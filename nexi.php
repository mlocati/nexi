<?php

declare(strict_types=1);

if (PHP_VERSION_ID < 70200) {
    echo "This library requires PHP 7.2+\n";
    exit(1);
}

spl_autoload_register(
    static function ($class) {
        if (strpos($class, 'MLocati\\Nexi\\') !== 0) {
            return;
        }
        $file = __DIR__ . '/src' . str_replace('\\', '/', substr($class, strlen('MLocati\\Nexi'))) . '.php';
        if (is_file($file)) {
            require_once $file;
        }
    }
);
