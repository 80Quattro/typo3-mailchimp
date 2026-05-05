<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die;

ExtensionUtility::registerPlugin(
    'MsMailchimp',
    'Subscription',
    'Mailchimp Subscription',
    'EXT:ms_mailchimp/Resources/Public/Icons/Extension.svg',
);
