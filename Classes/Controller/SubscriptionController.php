<?php

declare(strict_types=1);

namespace MarekSkopal\MsMailchimp\Controller;

use MarekSkopal\MsMailchimp\Client\MailchimpClient;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use const FILTER_VALIDATE_EMAIL;

class SubscriptionController extends ActionController
{
    public function __construct(private readonly MailchimpClient $mailchimpClient,)
    {
    }

    public function formAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    public function subscribeAction(string $email = ''): ResponseInterface
    {
        $email = trim($email);

        if ($email === '') {
            /** @phpstan-ignore new.internalClass, method.internalClass */
            return new JsonResponse([
                'success' => false,
                'message' => 'Please enter your email address',
            ]);
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            /** @phpstan-ignore new.internalClass, method.internalClass */
            return new JsonResponse([
                'success' => false,
                'message' => 'Please enter a valid email address',
            ]);
        }

        $response = $this->mailchimpClient->subscribe($email);

        /** @phpstan-ignore new.internalClass, method.internalClass */
        return new JsonResponse([
            'success' => $response->success,
            'message' => $response->message,
        ]);
    }
}
