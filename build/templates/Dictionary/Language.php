<?php

declare(strict_types=1);

namespace MLocati\Nexi\Dictionary;

use ReflectionClass;

/* <<TOPCOMMENT>> */

/* <<CLASS_PHPDOC>> */
class Language
{
    /* <<IDS>> */

    /**
     * @private
     */
    const NEXI_TO_ALPHA2 = [
        /* <<NEXI_TO_ALPHA2>> */
    ];

    /**
     * @private
     */
    const ALPHA2_TO_NEXI = [
        /* <<ALPHA2_TO_NEXI>> */
    ];

    /**
     * @return string[]
     */
    public function getAvailableIDs(): array
    {
        $result = [];
        $class = new ReflectionClass($this);
        foreach ($class->getConstants() as $name => $value) {
            if (strpos($name, 'ID_') === 0 && is_string($value)) {
                $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * Resolve a locale identifier (for example: 'it-IT@UTF-8') to a Nexi language identifier (for example 'ita')
     *
     * @return string empty string if no corresponding Nexi language identifier has been found
     */
    public function getNexiCodeFromLocale(string $localeID): string
    {
        [$language] = preg_split('/\\W/', str_replace('_', '-', $localeID), 2);

        return $this->getNexiCodeFromIso639Alpha2($language);
    }

    /**
     * Resolve an ISO-639 alpha2 language identifier (for example: 'it') to a Nexi language identifier (for example 'ita')
     *
     * @return string empty string if no corresponding Nexi language identifier has been found
     */
    public function getNexiCodeFromIso639Alpha2(string $alpha2LanguageID): string
    {
        $alpha2LanguageID = strtolower(trim($alpha2LanguageID));
        $map = array_change_key_case(static::ALPHA2_TO_NEXI, CASE_LOWER);
        if (isset($map[$alpha2LanguageID])) {
            return $map[$alpha2LanguageID];
        }
        $ids = $this->getAvailableIDs();
        $map = array_change_key_case(array_combine($ids, $ids), CASE_LOWER);
        if (isset($map[$alpha2LanguageID])) {
            return $map[$alpha2LanguageID];
        }

        return '';
    }
}
