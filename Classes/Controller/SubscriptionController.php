<?php

declare(strict_types=1);

namespace MarekSkopal\MsMailchimp\Controller;

use MarekSkopal\MsMailchimp\Client\MailchimpClient;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use const FILTER_VALIDATE_EMAIL;

class SubscriptionController extends ActionController
{
    public function __construct(private readonly MailchimpClient $mailchimpClient)
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
            return $this->createJsonResponse(false, 'Please enter your email address');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return $this->createJsonResponse(false, 'Please enter a valid email address');
        }

        $response = $this->mailchimpClient->subscribe($email);

        return $this->createJsonResponse($response->success, $response->message);
    }

    protected function createJsonResponse(bool $success, string $message): ResponseInterface
    {
        return $this->jsonResponse((string) json_encode([
            'success' => $success,
            'message' => $message,
        ]));
    }
}
