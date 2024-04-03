<?php

declare(strict_types=1);

namespace MLocati\Nexi\Test\Cases;

use PHPUnit\Framework\TestCase;

class ValidClassesTest extends TestCase
{
    /**
     * @return string[]
     */
    public static function provideClassNames(): array
    {
        $nsPrefix = 'MLocati\\Nexi\\';
        $dirPrefix = MLNEXI_TEST_ROOTDIR . '/src/';
        $result = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dirPrefix));
        foreach ($iterator as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isFile() && $file->getExtension() === 'php') {
                $result[] = [$nsPrefix . str_replace(DIRECTORY_SEPARATOR, '\\', substr($file->getPathname(), strlen($dirPrefix), -4))];
            }
        }

        return $result;
    }

    /**
     * @dataProvider provideClassNames
     */
    public function testOne(string $className): void
    {
        $this->assertTrue(class_exists($className) || interface_exists($className) || trait_exists($className), "Checking existance of {$className}");
    }
}
