<?php

declare(strict_types=1);

use MarekSkopal\MsMailchimp\Controller\SubscriptionController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    'MsMailchimp',
    'Subscription',
    [
        SubscriptionController::class => 'form, subscribe',
    ],
    [
        SubscriptionController::class => 'subscribe',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);