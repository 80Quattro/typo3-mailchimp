<?php

declare(strict_types=1);

namespace MarekSkopal\MsMailchimp\Client;

use MarekSkopal\MsMailchimp\Dto\SubscribeResponse;
use MarekSkopal\MsMailchimp\Utility\LocalizationUtility;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use const JSON_THROW_ON_ERROR;

readonly class MailchimpClient
{
    private const string API_VERSION = '3.0';

    public function __construct(
        private RequestFactory $requestFactory,
        /** @phpstan-ignore property.internalInterface, parameter.internalInterface */
        private ConfigurationManagerInterface $configurationManager,
        private LoggerInterface $logger,
    ) {
    }

    public function subscribe(string $email): SubscribeResponse
    {
        $settings = $this->getSettings();

        $apiKey = $settings['apiKey'];
        $serverPrefix = $settings['serverPrefix'];
        $listId = $settings['listId'];

        if ($apiKey === '' || $serverPrefix === '' || $listId === '') {
            return new SubscribeResponse(
                success: false,
                message: LocalizationUtility::translate('message.error.configurationIncomplete'),
            );
        }

        $url = sprintf('https://%s.api.mailchimp.com/%s/lists/%s/members', $serverPrefix, self::API_VERSION, $listId);

        $body = json_encode([
            'email_address' => $email,
            'status' => 'subscribed',
        ], JSON_THROW_ON_ERROR);

        try {
            $response = $this->requestFactory->request(
                $url,
                'POST',
                [
                    'headers' => [
                        'Authorization' => 'Basic ' . base64_encode('anystring:' . $apiKey),
                        'Content-Type' => 'application/json',
                    ],
                    'body' => $body,
                    'http_errors' => false,
                ],
            );

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($statusCode === 200) {
                return new SubscribeResponse(
                    success: true,
                    message: LocalizationUtility::translate('message.success.subscribed'),
                );
            }

            /** @var array{title?: string, detail?: string} $responseData */
            $responseData = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);

            if ($statusCode === 400 && ($responseData['title'] ?? '') === 'Member Exists') {
                return new SubscribeResponse(
                    success: false,
                    message: LocalizationUtility::translate('message.error.alreadySubscribed'),
                );
            }

            $this->logger->warning('Mailchimp API error', [
                'status' => $statusCode,
                'response' => $responseBody,
            ]);

            return new SubscribeResponse(
                success: false,
                message: LocalizationUtility::translate('message.error.subscriptionFailed'),
            );
        } catch (\Throwable $e) {
            $this->logger->error('Mailchimp API exception', [
                'exception' => $e->getMessage(),
            ]);

            return new SubscribeResponse(
                success: false,
                message: LocalizationUtility::translate('message.error.general'),
            );
        }
    }

    /** @return array{apiKey: string, serverPrefix: string, listId: string} */
    private function getSettings(): array
    {
        /** @phpstan-ignore method.internalInterface */
        $configuration = $this->configurationManager->getConfiguration(
            /** @phpstan-ignore classConstant.internalInterface */
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
        );

        $settings = [];
        if (
            isset($configuration['plugin.'])
            && is_array($configuration['plugin.'])
            && isset($configuration['plugin.']['tx_msmailchimp.'])
            && is_array($configuration['plugin.']['tx_msmailchimp.'])
            && isset($configuration['plugin.']['tx_msmailchimp.']['settings.'])
            && is_array($configuration['plugin.']['tx_msmailchimp.']['settings.'])
        ) {
            $settings = $configuration['plugin.']['tx_msmailchimp.']['settings.'];
        }

        return [
            'apiKey' => isset($settings['apiKey']) && is_string($settings['apiKey']) ? $settings['apiKey'] : '',
            'serverPrefix' => isset($settings['apiKey']) && is_string($settings['apiKey']) ? substr($settings['apiKey'], -3) : '',
            'listId' => isset($settings['listId']) && is_string($settings['listId']) ? $settings['listId'] : '',
        ];
    }
}
