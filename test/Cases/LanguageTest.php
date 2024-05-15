<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Test\Cases;

use MLocati\Nexi\XPayWeb\Dictionary\Language;
use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
    /**
     * @var \MLocati\Nexi\XPayWeb\Dictionary\Language
     */
    private static $language;

    public static function setUpBeforeClass(): void
    {
        self::$language = new Language();
    }

    public static function provideLocales(): array
    {
        return array_merge(self::provideCommonCases(), [
            ['it-IT', Language::ID_ITA],
            ['IT_IT', Language::ID_ITA],
            ['ITA_IT@UTF8', Language::ID_ITA],
            ['xx-IT', ''],
            ['xit-IT', ''],
            ['itx-IT', ''],
        ]);
    }

    /**
     * @dataProvider provideLocales
     */
    public function testLocales(string $localeID, string $expectedNexiID): void
    {
        $actualNexiID = self::$language->getNexiCodeFromLocale($localeID);
        $this->assertSame($expectedNexiID, $actualNexiID);
    }

    public static function provideAlpha2Languages(): array
    {
        return array_merge(self::provideCommonCases(), [
            ['it-IT', ''],
            ['it_IT', ''],
            ['xit', ''],
            ['itx', ''],
        ]);
    }

    /**
     * @dataProvider provideAlpha2Languages
     */
    public function testAlpha2(string $languageID, string $expectedNexiID): void
    {
        $actualNexiID = self::$language->getNexiCodeFromIso639Alpha2($languageID);
        $this->assertSame($expectedNexiID, $actualNexiID);
    }

    private static function provideCommonCases(): array
    {
        $result = [
            ['', ''],
            ['it', Language::ID_ITA],
            ['ita', Language::ID_ITA],
            ['IT', Language::ID_ITA],
            ['ITA', Language::ID_ITA],
        ];
        $language = new Language();
        foreach ($language->getAvailableIDs() as $id) {
            $result[] = [$id, $id];
            $result[] = [strtolower($id), $id];
            $result[] = [strtoupper($id), $id];
        }
        $result = array_unique($result, SORT_REGULAR);

        return array_values($result);
    }
}
