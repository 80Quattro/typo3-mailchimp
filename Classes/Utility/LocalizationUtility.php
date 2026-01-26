<?php

declare(strict_types=1);

namespace MarekSkopal\MsMailchimp\Utility;

final class LocalizationUtility
{
    private const string EXTENSION_NAME = 'MsMailchimp';

    public static function translate(string $key): string
    {
        return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, self::EXTENSION_NAME) ?? $key;
    }
}
