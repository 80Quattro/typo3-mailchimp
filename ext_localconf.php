<?php

declare(strict_types=1);

use MarekSkopal\MsMailchimp\Controller\SubscriptionController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
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

ExtensionManagementUtility::addPageTSConfig(
    'mod.wizards.newContentElement.wizardItems.plugins {
        elements {
            msmailchimp_subscription {
                iconIdentifier = msmailchimp-plugin-subscription
                title = Mailchimp Subscription
                description = Newsletter subscription form
                tt_content_defValues {
                    CType = msmailchimp_subscription
                }
            }
        }
        show := addToList(msmailchimp_subscription)
    }'
);