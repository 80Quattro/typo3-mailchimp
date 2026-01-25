<?php

declare(strict_types=1);

namespace MarekSkopal\MsMailchimp\Dto;

readonly class SubscribeResponse
{
    public function __construct(public bool $success, public string $message,)
    {
    }
}
